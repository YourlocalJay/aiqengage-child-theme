/**
 * Chat Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since 1.0.0
 * @author Jason
 */

(function () {
    'use strict';

    /**
     * Initialize the chat widget functionality
     */
    function initChatWidget() {
        // Find all chat widgets on the page
        const chatWidgets = document.querySelectorAll('.aiq-chat');

        if (!chatWidgets.length) {
            return;
        }

        // Initialize each chat widget
        chatWidgets.forEach(widget => {
            const settings = JSON.parse(widget.getAttribute('data-settings'));
            initSingleChat(widget, settings);
        });
    }

    /**
     * Initialize a single chat widget
     *
     * @param {HTMLElement} widget - The chat widget element
     * @param {Object} settings - The widget settings
     */
    function initSingleChat(widget, settings) {
        // Get DOM elements
        const container = widget.querySelector('.aiq-chat__container');
        const messagesContainer = widget.querySelector('.aiq-chat__messages');
        const quickRepliesContainer = widget.querySelector('.aiq-chat__quick-replies');
        const inputField = widget.querySelector('.aiq-chat__input');
        const sendButton = widget.querySelector('.aiq-chat__send-btn');
        const typingIndicator = widget.querySelector('.aiq-chat__typing-indicator');

        // Get floating chat elements if applicable
        const bubble = widget.querySelector('.aiq-chat__bubble');
        const closeButton = widget.querySelector('.aiq-chat__close');

        // Chat state
        const state = {
            messages: [],
            isTyping: false,
            chatOpen: settings.layoutType === 'standard',
            previouslyFocusedElement: null,
            focusableElements: []
        };

        // Set up accessibility attributes
        setupAccessibilityAttributes();

        // Focus management and trap setup
        setupFocusManagement();

        // Event listeners
        if (bubble) {
            bubble.addEventListener('click', toggleChat);
            bubble.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleChat();
                }
            });
        }

        if (closeButton) {
            closeButton.addEventListener('click', toggleChat);
            closeButton.addEventListener('keydown', (error) => {
                if (error.key === 'Enter' || error.key === ' ') {
                    error.preventDefault();
                    toggleChat();
                }
            });
        }

        // Global keyboard event handler for ESC key
        document.addEventListener('keydown', handleGlobalKeydown);

        // Input and send functionality
        if (sendButton) {
            sendButton.addEventListener('click', sendMessage);
        }

        if (inputField) {
            inputField.addEventListener('keydown', (e) => {
                if (settings.sendOnEnter === 'yes' && e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }

                // Auto-resize textarea
                setTimeout(() => {
                    inputField.style.height = 'auto';
                    inputField.style.height = inputField.scrollHeight + 'px';
                }, 0);
            });
        }

        // Show the greeting message
        if (settings.greetingMessage) {
            addMessage('ai', settings.greetingMessage);

            // Add quick replies if enabled
            if (settings.showQuickReplies === 'yes' && settings.quickReplies && settings.quickReplies.length) {
                showQuickReplies(settings.quickReplies);
            }
        }

        /**
         * Set up accessibility attributes for the chat widget
         */
        function setupAccessibilityAttributes() {
            // Set up modal role for floating chat
            if (settings.layoutType === 'floating') {
                container.setAttribute('role', 'dialog');
                container.setAttribute('aria-modal', 'true');
                container.setAttribute('aria-labelledby', 'chat-title');
                container.setAttribute('aria-describedby', 'chat-description');

                // Add heading for screen readers
                if (!container.querySelector('#chat-title')) {
                    const title = document.createElement('h2');
                    title.id = 'chat-title';
                    title.className = 'sr-only';
                    title.textContent = settings.aiName + ' Chat Assistant';
                    container.insertBefore(title, container.firstChild);
                }

                // Add description for screen readers
                if (!container.querySelector('#chat-description')) {
                    const description = document.createElement('p');
                    description.id = 'chat-description';
                    description.className = 'sr-only';
                    description.textContent = 'Interactive chat with AI assistant. Use Tab to navigate, Enter to activate buttons, Escape to close.';
                    container.insertBefore(description, container.firstChild);
                }
            }

            // Set up messages container as live region
            messagesContainer.setAttribute('aria-live', 'polite');
            messagesContainer.setAttribute('aria-label', 'Chat messages');
            messagesContainer.setAttribute('role', 'log');

            // Set up input field
            inputField.setAttribute('aria-label', 'Type your message');
            inputField.setAttribute('aria-describedby', 'send-instructions');

            // Add instructions for screen readers
            if (!widget.querySelector('#send-instructions')) {
                const instructions = document.createElement('div');
                instructions.id = 'send-instructions';
                instructions.className = 'sr-only';
                instructions.textContent = settings.sendOnEnter === 'yes'
                    ? 'Press Enter to send message, Shift+Enter for new line'
                    : 'Use the send button to send your message';
                inputField.parentNode.appendChild(instructions);
            }

            // Set up send button
            if (sendButton) {
                sendButton.setAttribute('aria-label', 'Send message');
            }

            // Set up close button if exists
            if (closeButton) {
                closeButton.setAttribute('aria-label', 'Close chat');
            }

            // Set up bubble if exists
            if (bubble) {
                bubble.setAttribute('aria-label', 'Open chat with ' + settings.aiName);
                bubble.setAttribute('role', 'button');
                bubble.setAttribute('tabindex', '0');
            }
        }

        /**
         * Set up focus management and trap
         */
        function setupFocusManagement() {
            updateFocusableElements();
        }

        /**
         * Update the list of focusable elements within the chat
         */
        function updateFocusableElements() {
            const focusableSelectors = [
                'a[href]',
                'button:not([disabled])',
                'input:not([disabled])',
                'textarea:not([disabled])',
                'select:not([disabled])',
                '[tabindex]:not([tabindex="-1"])'
            ].join(', ');

            state.focusableElements = Array.from(container.querySelectorAll(focusableSelectors))
                .filter(el => el.offsetParent !== null); // Only visible elements
        }

        /**
         * Handle global keyboard events (primarily ESC key)
         */
        function handleGlobalKeydown(e) {
            if (e.key === 'Escape' && state.chatOpen && settings.layoutType === 'floating') {
                e.preventDefault();
                toggleChat();
            }

            // Handle Tab key for focus trapping in floating chat
            if (e.key === 'Tab' && state.chatOpen && settings.layoutType === 'floating') {
                handleTabKey(e);
            }
        }

        /**
         * Handle Tab key for focus trapping
         */
        function handleTabKey(e) {
            if (state.focusableElements.length === 0) return;

            const firstElement = state.focusableElements[0];
            const lastElement = state.focusableElements[state.focusableElements.length - 1];

            if (e.shiftKey) {
                // Shift + Tab
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                // Tab
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        }

        /**
         * Toggle the chat open/closed state (for floating chat)
         */
        function toggleChat() {
            if (settings.layoutType !== 'floating') return;

            state.chatOpen = !state.chatOpen;

            if (state.chatOpen) {
                // Store previously focused element
                state.previouslyFocusedElement = document.activeElement;

                container.style.display = 'flex';
                // Animate opening
                setTimeout(() => {
                    container.style.opacity = '1';
                    container.style.transform = 'translateY(0)';

                    // Update focusable elements
                    updateFocusableElements();

                    // Focus on input after opening
                    inputField.focus();

                    // Announce opening to screen readers
                    announceToScreenReader('Chat opened');
                }, 10);

                // Remove notification pulse
                if (bubble) {
                    bubble.classList.remove('pulse');
                }
            } else {
                // Animate closing
                container.style.opacity = '0';
                container.style.transform = 'translateY(20px)';

                // Hide after animation
                setTimeout(() => {
                    container.style.display = 'none';

                    // Restore focus to previously focused element
                    if (state.previouslyFocusedElement && document.body.contains(state.previouslyFocusedElement)) {
                        state.previouslyFocusedElement.focus();
                    } else if (bubble) {
                        bubble.focus();
                    }

                    // Announce closing to screen readers
                    announceToScreenReader('Chat closed');
                }, 300);
            }
        }

        /**
         * Send a message from the user
         */
        function sendMessage() {
            const message = inputField.value.trim();

            if (!message) return;

            // Add user message to chat
            addMessage('user', message);

            // Clear input field
            inputField.value = '';
            inputField.style.height = 'auto';

            // Hide quick replies
            hideQuickReplies();

            // Process the message
            processUserMessage(message);
        }

        /**
         * Process user message and generate a response
         *
         * @param {string} message - The user's message
         */
        function processUserMessage(message) {
            // Show typing indicator
            showTypingIndicator();

            // If API integration is enabled
            if (settings.enableApi === 'yes' && settings.apiEndpoint) {
                // Call the API endpoint
                fetch(settings.apiEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ message: message }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Hide typing indicator
                    hideTypingIndicator();

                    // Add AI response
                    if (data.response) {
                        addMessage('ai', data.response);
                    } else {
                        // Fallback if no response property
                        addMessage('ai', 'I received your message, but I\'m not sure how to respond. Could you try rephrasing?');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideTypingIndicator();

                    // Add fallback message
                    addMessage('ai', settings.fallbackMessage || 'I\'m having trouble connecting right now. Please try again later.');
                });
            } else {
                // Simulate typing delay for demo
                setTimeout(() => {
                    hideTypingIndicator();

                    // Add predefined response based on user message
                    const response = getSimulatedResponse(message);
                    addMessage('ai', response);

                    // Show follow-up quick replies if appropriate
                    if (shouldShowFollowUpQuickReplies(message)) {
                        const followUpReplies = getFollowUpQuickReplies(message);
                        if (followUpReplies.length) {
                            showQuickReplies(followUpReplies);
                        }
                    }
                }, 1000 + Math.random() * 1000); // Random delay between 1-2 seconds
            }
        }

        /**
         * Add a message to the chat
         *
         * @param {string} sender - The message sender ('ai' or 'user')
         * @param {string} text - The message text
         */
        function addMessage(sender, text) {
            // Create message element
            const messageEl = document.createElement('div');
            messageEl.className = `aiq-chat__message aiq-chat__message--${sender}`;

            // Add ARIA attributes for accessibility
            messageEl.setAttribute('role', 'listitem');
            messageEl.setAttribute('aria-label', `Message from ${sender === 'ai' ? settings.aiName : 'You'}: ${text}`);

            // Create avatar
            const avatarEl = document.createElement('div');
            avatarEl.className = 'aiq-chat__avatar';
            avatarEl.setAttribute('aria-hidden', 'true');

            const avatarImg = document.createElement('img');
            if (sender === 'ai') {
                avatarImg.src = settings.aiAvatar;
                avatarImg.alt = settings.aiName;
            } else {
                // Default user avatar (silhouette)
                avatarImg.src = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iI0UwRDZGRiI+PHBhdGggZD0iTTEyIDJDNi40OCAyIDIgNi40OCAyIDEyczQuNDggMTAgMTAgMTAgMTAtNC40OCAxMC0xMFMxNy41MiAyIDEyIDJ6bTAgM2MyLjY3IDAgOCA1LjMxIDggMTJoLTE2YzAtNi42OSA1LjMzLTEyIDgtMTJ6bTAgMmMtMS4xMSAwLTIgLjktMiAyIDAgMS4xMS44OSAyIDIgMnMyLS44OSAyLTItLjg5LTItMi0yeiIvPjwvc3ZnPg==';
                avatarImg.alt = 'User';
            }

            avatarEl.appendChild(avatarImg);

            // Create message bubble
            const bubbleEl = document.createElement('div');
            bubbleEl.className = 'aiq-chat__message-bubble';
            bubbleEl.textContent = text;

            // Assemble message
            messageEl.appendChild(avatarEl);
            messageEl.appendChild(bubbleEl);

            // Add to messages container
            messagesContainer.appendChild(messageEl);

            // Save to state
            state.messages.push({
                sender,
                text
            });

            // Scroll to bottom
            scrollToBottom();

            // Announce new message to screen readers
            announceToScreenReader(`New message from ${sender === 'ai' ? settings.aiName : 'You'}: ${text}`);

            // Notify floating chat if minimized
            if (settings.layoutType === 'floating' && !state.chatOpen && sender === 'ai' && bubble) {
                bubble.classList.add('pulse');
            }
        }

        /**
         * Show typing indicator
         */
        function showTypingIndicator() {
            state.isTyping = true;
            typingIndicator.style.display = 'flex';
            typingIndicator.setAttribute('aria-label', `${settings.aiName} is typing`);

            // Announce typing to screen readers
            announceToScreenReader(`${settings.aiName} is typing...`);
        }

        /**
         * Hide typing indicator
         */
        function hideTypingIndicator() {
            state.isTyping = false;
            typingIndicator.style.display = 'none';
        }

        /**
         * Show quick reply buttons
         *
         * @param {Array} replies - Array of quick reply texts
         */
        function showQuickReplies(replies) {
            // Clear existing quick replies
            quickRepliesContainer.innerHTML = '';

            // Add reply buttons
            replies.forEach((reply, index) => {
                const replyBtn = document.createElement('button');
                replyBtn.className = 'aiq-chat__quick-reply-btn';
                replyBtn.textContent = reply;
                replyBtn.setAttribute('type', 'button');
                replyBtn.setAttribute('aria-label', `Quick reply: ${reply}`);

                // Keyboard support for quick replies
                replyBtn.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft' && index > 0) {
                        e.preventDefault();
                        quickRepliesContainer.children[index - 1].focus();
                    } else if (e.key === 'ArrowRight' && index < replies.length - 1) {
                        e.preventDefault();
                        quickRepliesContainer.children[index + 1].focus();
                    } else if (e.key === 'Home') {
                        e.preventDefault();
                        quickRepliesContainer.children[0].focus();
                    } else if (e.key === 'End') {
                        e.preventDefault();
                        quickRepliesContainer.children[replies.length - 1].focus();
                    }
                });

                replyBtn.addEventListener('click', () => {
                    // Add as user message
                    addMessage('user', reply);

                    // Hide quick replies
                    hideQuickReplies();

                    // Process as user message
                    processUserMessage(reply);
                });

                quickRepliesContainer.appendChild(replyBtn);
            });

            // Show the container
            quickRepliesContainer.style.display = 'block';
            quickRepliesContainer.setAttribute('aria-label', 'Quick reply options');

            // Update focusable elements
            updateFocusableElements();

            // Announce quick replies availability
            announceToScreenReader(`${replies.length} quick reply options available. Use arrow keys to navigate.`);
        }

        /**
         * Hide quick reply buttons
         */
        function hideQuickReplies() {
            quickRepliesContainer.style.display = 'none';
            updateFocusableElements();
        }

        /**
         * Scroll messages container to bottom
         */
        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        /**
         * Announce message to screen readers
         */
        function announceToScreenReader(message) {
            // Create or get the announcer element
            let announcer = document.getElementById('aiq-chat-announcer');
            if (!announcer) {
                announcer = document.createElement('div');
                announcer.id = 'aiq-chat-announcer';
                announcer.setAttribute('aria-live', 'polite');
                announcer.setAttribute('aria-atomic', 'true');
                announcer.className = 'sr-only';
                document.body.appendChild(announcer);
            }

            // Clear previous announcement
            announcer.textContent = '';

            // Make announcement after a brief delay to ensure screen readers pick it up
            setTimeout(() => {
                announcer.textContent = message;
            }, 100);

            // Clear after announcement
            setTimeout(() => {
                announcer.textContent = '';
            }, 3000);
        }

        /**
         * Get a simulated response based on user input (for demo without API)
         *
         * @param {string} message - The user's message
         * @return {string} The simulated response
         */
        function getSimulatedResponse(message) {
            const lowerMessage = message.toLowerCase();

            // Check for common phrases/keywords
            if (lowerMessage.includes('traffic') || lowerMessage.includes('visitors') || lowerMessage.includes('audience')) {
                return "Great! For traffic generation, I recommend our Reddit Authority Builder prompt sequence. It helps you create authentic, high-quality Reddit comments that establish expertise without being promotional. Would you like to see how it works?";
            }

            if (lowerMessage.includes('conversion') || lowerMessage.includes('sales') || lowerMessage.includes('leads')) {
                return "For improving conversions, our Landing Page Optimizer prompt kit is highly effective. It helps you identify conversion bottlenecks and create compelling copy that resonates with your target audience. The average conversion lift is around 37% for our users.";
            }

            if (lowerMessage.includes('content') || lowerMessage.includes('writing') || lowerMessage.includes('blog')) {
                return "Content automation is one of Claude's strengths! Our Content Scaling Blueprint helps you create consistent, high-quality content across multiple channels. It includes prompts for outlining, drafting, editing, and repurposing content for different platforms.";
            }

            if (lowerMessage.includes('affiliate') || lowerMessage.includes('monetize') || lowerMessage.includes('revenue')) {
                return "For affiliate marketing, our Ethical Review Generator prompt sequence helps you create authentic, high-converting product reviews without sounding salesy. It includes templates for different product categories and conversion-optimized layouts.";
            }

            // Default response for other queries
            return "Thanks for sharing! To help you better, could you tell me more about your specific goals? I can recommend automation templates for traffic generation, content creation, conversions, or monetization.";
        }

        /**
         * Determine if follow-up quick replies should be shown
         *
         * @param {string} message - The user's message
         * @return {boolean} Whether to show follow-up quick replies
         */
        function shouldShowFollowUpQuickReplies(message) {
            const lowerMessage = message.toLowerCase();

            return lowerMessage.includes('traffic') ||
                   lowerMessage.includes('conversion') ||
                   lowerMessage.includes('content') ||
                   lowerMessage.includes('affiliate');
        }

        /**
         * Get contextual follow-up quick replies based on user message
         *
         * @param {string} message - The user's message
         * @return {Array} Array of quick reply texts
         */
        function getFollowUpQuickReplies(message) {
            const lowerMessage = message.toLowerCase();

            if (lowerMessage.includes('traffic') || lowerMessage.includes('visitors')) {
                return [
                    "Show me the Reddit Strategy",
                    "How much traffic can I expect?",
                    "I need more specific guidance"
                ];
            }

            if (lowerMessage.includes('conversion') || lowerMessage.includes('sales')) {
                return [
                    "Tell me about landing page prompts",
                    "What's the average conversion lift?",
                    "How do I implement this?"
                ];
            }

            if (lowerMessage.includes('content') || lowerMessage.includes('writing')) {
                return [
                    "Show me content automation examples",
                    "How much content can I create?",
                    "Tell me about the Blueprint"
                ];
            }

            if (lowerMessage.includes('affiliate') || lowerMessage.includes('monetize')) {
                return [
                    "Tell me about the Review Generator",
                    "Which affiliate programs work best?",
                    "How do I get started?"
                ];
            }

            return [
                "Tell me about traffic generation",
                "I need help with conversions",
                "Show me content automation tools",
                "How can I monetize with affiliates?"
            ];
        }
    }

    // Initialize on document ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChatWidget);
    } else {
        initChatWidget();
    }
})();
