/**
 * Quiz Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */


(function($) {
  'use strict';

  // Quiz Class
  class AIQQuiz {
    constructor(element, options) {
      this.element = element;
      this.options = options;
      this.currentQuestion = 0;
      this.answers = [];
      this.score = 0;
      this.totalQuestions = this.options.questions.length;
      this.resultMessage = {};
      this.capturedLead = false;

      // Initialize
      this.init();
    }

    // Initialize quiz
    init() {
      this.bindEvents();
      this.setupAccessibility();
    }

    // Bind events
    bindEvents() {
      const quiz = this;
      const $quiz = $(this.element);

      // Start button
      $quiz.find('.aiq-quiz__start-button').on('click', function() {
        quiz.startQuiz();
      });

      // Next button
      $quiz.find('.aiq-quiz__next-button').on('click', function() {
        quiz.validateAndContinue();
      });

      // Previous button
      $quiz.find('.aiq-quiz__prev-button').on('click', function() {
        quiz.goToPreviousQuestion();
      });

      // Finish button
      $quiz.find('.aiq-quiz__finish-button').on('click', function() {
        quiz.finishQuiz();
      });

      // Restart button
      $quiz.find('.aiq-quiz__restart-button').on('click', function() {
        quiz.restartQuiz();
      });

      // Lead form submission
      $quiz.find('.aiq-quiz__lead-form').on('submit', function(e) {
        e.preventDefault();
        quiz.processLeadForm();
      });

      // Keyboard navigation for answer options
      $quiz.find('.aiq-quiz__answer-option').on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          $(this).find('input').prop('checked', true).trigger('change');
        }
      });

      // Answer option selection
      $quiz.find('.aiq-quiz__answer-input').on('change', function() {
        const $option = $(this).closest('.aiq-quiz__answer-option');
        const $options = $option.parent().find('.aiq-quiz__answer-option');

        if ($(this).attr('type') === 'radio') {
          $options.removeClass('is-selected');
        }

        $option.toggleClass('is-selected', this.checked);
        // Set aria-pressed attribute for accessibility
        $option.attr('aria-pressed', this.checked ? 'true' : 'false');
      });

      // Handle open answer changes
      $quiz.find('.aiq-quiz__open-answer').on('input', function() {
        // Store answer as user types
        const questionIndex = $(this).closest('.aiq-quiz__question').data('question-index');
        quiz.storeAnswer(questionIndex);
      });
    }

    // Setup accessibility features
    setupAccessibility() {
      const $quiz = $(this.element);

      // Make radio buttons and checkboxes accessible
      $quiz.find('.aiq-quiz__answer-option')
           .attr('tabindex', '0')
           .attr('role', 'button')
           .attr('aria-pressed', 'false');

      // Set up aria labels for progress
      if (this.options.show_progress_bar === 'yes') {
        $quiz.find('.aiq-quiz__progress-bar')
             .attr('aria-valuemin', '0')
             .attr('aria-valuemax', '100')
             .attr('aria-valuenow', '0');
      }

      // Add screen reader text for better context
      $quiz.find('.aiq-quiz__start-button').attr('aria-label', 'Start the quiz');
      $quiz.find('.aiq-quiz__next-button').attr('aria-label', 'Go to next question');
      $quiz.find('.aiq-quiz__prev-button').attr('aria-label', 'Go to previous question');
      $quiz.find('.aiq-quiz__finish-button').attr('aria-label', 'Submit answers and finish the quiz');
    }

    // Start the quiz
    startQuiz() {
      const $quiz = $(this.element);

      // Handle lead capture before quiz if configured
      if (this.options.enable_lead_capture === 'yes' &&
          this.options.lead_capture_position === 'before_quiz' &&
          !this.capturedLead) {
        this.showLeadForm();
        return;
      }

      $quiz.find('.aiq-quiz__start-screen').hide();
      $quiz.find('.aiq-quiz__container').show();

      // Show first question
      this.showQuestion(0);

      // Initialize storage if needed
      this.answers = new Array(this.totalQuestions).fill(null);

      // Store in localStorage for later
      if (typeof Storage !== 'undefined') {
        localStorage.setItem('aiq_quiz_' + this.options.id + '_progress', JSON.stringify({
          currentQuestion: 0,
          answers: this.answers
        }));
      }
    }

    // Show lead capture form
    showLeadForm() {
      const $quiz = $(this.element);

      $quiz.find('.aiq-quiz__start-screen').hide();
      $quiz.find('.aiq-quiz__container').hide();
      $quiz.find('.aiq-quiz__results').hide();
      $quiz.find('.aiq-quiz__form').show().addClass('aiq-quiz__fade-in');
    }

    // Process lead form submission
    processLeadForm() {
      const $quiz = $(this.element);
      const quiz = this;
      const $form = $quiz.find('.aiq-quiz__lead-form');

      // Validate form
      if (!$form[0].checkValidity()) {
        $form[0].reportValidity();
        return;
      }

      // Get form data
      const formData = {
        name: $quiz.find('#' + this.options.id + '-name').val(),
        email: $quiz.find('#' + this.options.id + '-email').val()
      };

      // Store the lead data in localStorage (in a real implementation, you would send to server)
      if (typeof Storage !== 'undefined') {
        localStorage.setItem('aiq_quiz_' + this.options.id + '_lead', JSON.stringify(formData));
      }

      // Mark as captured
      this.capturedLead = true;

      // If lead capture was before quiz, start the quiz now
      if (this.options.lead_capture_position === 'before_quiz') {
        $quiz.find('.aiq-quiz__form').hide();
        $quiz.find('.aiq-quiz__container').show();
        this.showQuestion(0);
      } else {
        // If lead capture was after quiz, show results
        $quiz.find('.aiq-quiz__form').hide();
        this.showResults();
      }

      // Optional: Trigger event for external tracking
      $quiz.trigger('aiqQuizLeadCaptured', [formData]);
    }

    // Show a specific question
    showQuestion(index) {
      const $quiz = $(this.element);

      // Hide all questions
      $quiz.find('.aiq-quiz__question').hide();

      // Show the requested question
      $quiz.find('.aiq-quiz__question').eq(index).show()
           .addClass('aiq-quiz__slide-up');

      // Update progress
      this.updateProgress(index);

      // Update current question index
      this.currentQuestion = index;

      // Pre-fill the answer if available
      this.preloadAnswer(index);

      // Update navigation buttons
      this.updateNavigation(index);

      // Announce question to screen readers
      const questionText = this.options.questions[index].question;
      this.announceToScreenReader('Question ' + (index + 1) + ' of ' + this.totalQuestions + ': ' + questionText);
    }

    // Preload previously saved answer
    preloadAnswer(index) {
      const $quiz = $(this.element);
      const questionType = this.options.questions[index].question_type;
      const $question = $quiz.find('.aiq-quiz__question').eq(index);

      if (this.answers[index] !== null) {
        if (questionType === 'open') {
          $question.find('.aiq-quiz__open-answer').val(this.answers[index]);
        } else if (questionType === 'single') {
          const answer = this.answers[index];
          $question.find('.aiq-quiz__answer-input[value="' + answer + '"]').prop('checked', true).trigger('change');
        } else if (questionType === 'multiple') {
          const answers = this.answers[index] || [];
          answers.forEach(answer => {
            $question.find('.aiq-quiz__answer-input[value="' + answer + '"]').prop('checked', true).trigger('change');
          });
        }
      }
    }

    // Update progress bar and text
    updateProgress(index) {
      const $quiz = $(this.element);

      if (this.options.show_progress_bar === 'yes') {
        // Update progress text
        $quiz.find('.aiq-quiz__current-question').text(index + 1);
        $quiz.find('.aiq-quiz__total-questions').text(this.totalQuestions);

        // Update progress bar
        const progress = ((index + 1) / this.totalQuestions) * 100;
        $quiz.find('.aiq-quiz__progress-bar-fill').css('width', progress + '%');
        $quiz.find('.aiq-quiz__progress-bar').attr('aria-valuenow', progress);
      }
    }

    // Update navigation buttons
    updateNavigation(index) {
      const $quiz = $(this.element);

      // Show/hide previous button
      if (index === 0) {
        $quiz.find('.aiq-quiz__prev-button').hide();
      } else {
        $quiz.find('.aiq-quiz__prev-button').show();
      }

      // Show next or finish button
      if (index === this.totalQuestions - 1) {
        $quiz.find('.aiq-quiz__next-button').hide();
        $quiz.find('.aiq-quiz__finish-button').show();
      } else {
        $quiz.find('.aiq-quiz__next-button').show();
        $quiz.find('.aiq-quiz__finish-button').hide();
      }
    }

    // Validate current answer and proceed to next question
    validateAndContinue() {
      const questionIndex = this.currentQuestion;

      // Store the answer
      this.storeAnswer(questionIndex);

      // Go to next question
      this.goToNextQuestion();
    }

    // Store the current answer
    storeAnswer(questionIndex) {
      const $quiz = $(this.element);
      const $question = $quiz.find('.aiq-quiz__question').eq(questionIndex);
      const questionType = this.options.questions[questionIndex].question_type;

      if (questionType === 'open') {
        // For open questions, store the text
        const answer = $question.find('.aiq-quiz__open-answer').val();
        this.answers[questionIndex] = answer;
      } else if (questionType === 'single') {
        // For single choice, store the selected option
        const $selected = $question.find('.aiq-quiz__answer-input:checked');

        if ($selected.length > 0) {
          this.answers[questionIndex] = $selected.val();
        } else {
          this.answers[questionIndex] = null;
        }
      } else if (questionType === 'multiple') {
        // For multiple choice, store all selected options
        const selectedValues = [];
        $question.find('.aiq-quiz__answer-input:checked').each(function() {
          selectedValues.push($(this).val());
        });

        if (selectedValues.length > 0) {
          this.answers[questionIndex] = selectedValues;
        } else {
          this.answers[questionIndex] = null;
        }
      }

      // Save progress to localStorage
      if (typeof Storage !== 'undefined') {
        localStorage.setItem('aiq_quiz_' + this.options.id + '_progress', JSON.stringify({
          currentQuestion: this.currentQuestion,
          answers: this.answers
        }));
      }
    }

    // Go to the next question
    goToNextQuestion() {
      if (this.currentQuestion < this.totalQuestions - 1) {
        this.showQuestion(this.currentQuestion + 1);
      }
    }

    // Go to the previous question
    goToPreviousQuestion() {
      if (this.currentQuestion > 0) {
        this.showQuestion(this.currentQuestion - 1);
      }
    }

    // Finish the quiz
    finishQuiz() {
      // Store the answer for the last question
      this.storeAnswer(this.currentQuestion);

      // Calculate score
      this.calculateScore();

      // Determine result message
      this.determineResultMessage();

      // Handle lead capture before showing results if configured
      if (this.options.enable_lead_capture === 'yes' &&
          this.options.lead_capture_position === 'before_results' &&
          !this.capturedLead) {
        this.showLeadForm();
        return;
      }

      // Show results
      this.showResults();
    }

    // Calculate the quiz score
    calculateScore() {
      let correctAnswers = 0;

      this.options.questions.forEach((question, index) => {
        const userAnswer = this.answers[index];

        if (userAnswer !== null) {
          if (question.question_type === 'single') {
            // For single choice, direct comparison
            if (userAnswer === question.correct_answer) {
              correctAnswers++;
            }
          } else if (question.question_type === 'multiple') {
            // For multiple choice, compare arrays
            if (!question.correct_answer) return;
            const correctOptions = question.correct_answer.split('\n').map(option => option.trim());
            const allCorrect = userAnswer.length === correctOptions.length &&
                              userAnswer.every(option => correctOptions.includes(option));

            if (allCorrect) {
              correctAnswers++;
            }
          } else if (question.question_type === 'open') {
            // For open answer, check against acceptable patterns
            if (!question.correct_answer) return;
            const acceptableAnswers = question.correct_answer.split('\n').map(ans => ans.trim().toLowerCase());
            const userAnswerLower = userAnswer.trim().toLowerCase();

            if (acceptableAnswers.some(acceptable => userAnswerLower.includes(acceptable))) {
              correctAnswers++;
            }
          }
        }
      });

      // Calculate percentage
      this.score = (correctAnswers / this.totalQuestions) * 100;
    }

    // Determine the result message based on score
    determineResultMessage() {
      const score = this.score;

      // Find the appropriate message for the score
      for (const message of this.options.result_messages) {
        const minScore = parseInt(message.min_score, 10);
        const maxScore = parseInt(message.max_score, 10);

        if (score >= minScore && score <= maxScore) {
          this.resultMessage = message;
          break;
        }
      }

      // If no message matches, use the first one as fallback
      if (!this.resultMessage.result_title && this.options.result_messages.length > 0) {
        this.resultMessage = this.options.result_messages[0];
      }
    }

    // Show quiz results
    showResults() {
      const $quiz = $(this.element);
      const isPassed = this.score >= this.options.pass_score;

      // Hide questions
      $quiz.find('.aiq-quiz__container').hide();

      // Show results
      $quiz.find('.aiq-quiz__results').show().addClass('aiq-quiz__fade-in');

      // Set score
      $quiz.find('.aiq-quiz__score').text(Math.round(this.score) + '%');

      // Set pass/fail text
      $quiz.find('.aiq-quiz__score-text').text(isPassed ?
        'Congratulations! You passed the quiz.' :
        'You did not pass the quiz.');

      // Add result class
      $quiz.find('.aiq-quiz__score').removeClass('is-passed is-failed')
           .addClass(isPassed ? 'is-passed' : 'is-failed');

      // Set result message
      $quiz.find('.aiq-quiz__result-title').text(this.resultMessage.result_title);
      $quiz.find('.aiq-quiz__result-description').text(this.resultMessage.result_description);

      // Set CTA button
      const $cta = $quiz.find('.aiq-quiz__result-cta');
      $cta.text(this.resultMessage.result_cta_text);
      $cta.attr('href', this.resultMessage.result_cta_url.url);

      if (this.resultMessage.result_cta_url.is_external) {
        $cta.attr('target', '_blank');
      }

      if (this.resultMessage.result_cta_url.nofollow) {
        $cta.attr('rel', 'nofollow');
      }

      // Custom attributes
      if (this.resultMessage.result_cta_url.custom_attributes) {
        const attributes = this.resultMessage.result_cta_url.custom_attributes.split(',');
        attributes.forEach(attr => {
          const [key, value] = attr.split('|');
          $cta.attr(key.trim(), value.trim());
        });
      }

      // Optional: Show review of answers if enabled
      if (this.options.show_correct_answers === 'yes') {
        this.showAnswerReview();
      }

      // Announce results to screen readers
      this.announceToScreenReader('Quiz complete. Your score is ' + Math.round(this.score) + ' percent.');

      // Trigger completion event
      $quiz.trigger('aiqQuizCompleted', [{
        score: this.score,
        isPassed: isPassed,
        answers: this.answers
      }]);
    }

    // Show review of correct answers
    showAnswerReview() {
      const $quiz = $(this.element);
      let reviewHtml = '<div class="aiq-quiz__answer-review">';
      reviewHtml += '<h3>' + 'Review Your Answers' + '</h3>';

      this.options.questions.forEach((question, index) => {
        const userAnswer = this.answers[index];
        let isCorrect = false;

        // Determine if answer was correct
        if (userAnswer !== null) {
          if (question.question_type === 'single') {
            isCorrect = userAnswer === question.correct_answer;
          } else if (question.question_type === 'multiple') {
            if (!question.correct_answer) return;
            const correctOptions = question.correct_answer.split('\n').map(option => option.trim());
            isCorrect = userAnswer.length === correctOptions.length &&
                        userAnswer.every(option => correctOptions.includes(option));
          } else if (question.question_type === 'open') {
            if (!question.correct_answer) return;
            const acceptableAnswers = question.correct_answer.split('\n').map(ans => ans.trim().toLowerCase());
            const userAnswerLower = userAnswer.trim().toLowerCase();
            isCorrect = acceptableAnswers.some(acceptable => userAnswerLower.includes(acceptable));
          }
        }

        reviewHtml += '<div class="aiq-quiz__review-item">';
        reviewHtml += '<div class="aiq-quiz__review-question">' + question.question + '</div>';

        // Show user's answer
        reviewHtml += '<div class="aiq-quiz__review-answer ' + (isCorrect ? 'is-correct' : 'is-incorrect') + '">';
        reviewHtml += '<span class="aiq-quiz__review-label">' + 'Your answer: ' + '</span>';

        if (question.question_type === 'multiple' && Array.isArray(userAnswer)) {
          reviewHtml += userAnswer.join(', ') || 'No answer provided';
        } else {
          reviewHtml += userAnswer || 'No answer provided';
        }

        reviewHtml += '</div>';

        // Show correct answer
        if (!isCorrect && this.options.show_correct_answers === 'yes') {
          reviewHtml += '<div class="aiq-quiz__review-correct">';
          reviewHtml += '<span class="aiq-quiz__review-label">' + 'Correct answer: ' + '</span>';

          if (question.question_type === 'multiple') {
            if (!question.correct_answer) {
              reviewHtml += '';
            } else {
              reviewHtml += question.correct_answer.split('\n').join(', ');
            }
          } else {
            reviewHtml += question.correct_answer || '';
          }

          reviewHtml += '</div>';
        }

        // Show explanation if available
        if (this.options.show_explanation === 'yes' && question.feedback) {
          reviewHtml += '<div class="aiq-quiz__review-explanation">';
          reviewHtml += '<span class="aiq-quiz__review-label">' + 'Explanation: ' + '</span>';
          reviewHtml += question.feedback;
          reviewHtml += '</div>';
        }

        reviewHtml += '</div>'; // End review item
      });

      reviewHtml += '</div>'; // End review

      // Append to results
      $quiz.find('.aiq-quiz__results').append(reviewHtml);
    }

    // Restart the quiz
    restartQuiz() {
      const $quiz = $(this.element);

      // Reset state
      this.currentQuestion = 0;
      this.answers = new Array(this.totalQuestions).fill(null);
      this.score = 0;
      this.resultMessage = {};

      // Clear localStorage
      if (typeof Storage !== 'undefined') {
        localStorage.removeItem('aiq_quiz_' + this.options.id + '_progress');
      }

      // Reset UI
      $quiz.find('.aiq-quiz__answer-input').prop('checked', false);
      $quiz.find('.aiq-quiz__answer-option').removeClass('is-selected is-correct is-incorrect');
      $quiz.find('.aiq-quiz__open-answer').val('');
      $quiz.find('.aiq-quiz__feedback').hide().empty();
      $quiz.find('.aiq-quiz__answer-review').remove();

      // Hide results
      $quiz.find('.aiq-quiz__results').hide();

      // Show start screen
      $quiz.find('.aiq-quiz__start-screen').show();

      // Announce to screen readers
      this.announceToScreenReader('Quiz restarted');
    }

    // Announce messages to screen readers
    announceToScreenReader(message) {
      // Create an ARIA live region if it doesn't exist
      let $announcer = $('#aiq-quiz-announcer');
      if ($announcer.length === 0) {
        $announcer = $('<div id="aiq-quiz-announcer" class="screen-reader-text" aria-live="polite" role="region"></div>');
        $('body').append($announcer);
      }

      // Update the announcement
      $announcer.text(message);

      // Clear it after a delay
      setTimeout(() => {
        $announcer.text('');
      }, 3000);
    }
  }

  // Initialize all quizzes
  $(document).ready(function() {
    $('.aiq-quiz').each(function() {
      const quizId = $(this).data('quiz-id');
      const quizData = window['aiqQuizData_' + quizId];

      if (quizData) {
        new AIQQuiz(this, quizData);
      } else {
        console.warn('AIQ Quiz: No quiz data found for quiz ID:', quizId);
      }
    });
  });

})(jQuery);
