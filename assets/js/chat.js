// assets/js/chat.js

/**
 * AIQEngage Chat Widget
 * 
 * A modular chat widget for the AIQEngage Elementor theme
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
            chatOpen: settings.layoutType === 'standard'
        };

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
        }

        // Input and send functionality
        sendButton.addEventListener('click', sendMessage);
        
        inputField.addEventListener('keydown', (e) => {
            if (settings.sendOnEnter === 'yes' && e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
            
            // Auto-resize textarea
            setTimeout(() => {
                inputField.style.height = 'auto';
                inputField.style.height = (inputField.scrollHeight) + 'px';
            }, 0);
        });

        // Show the greeting message
        if (settings.greetingMessage) {
            addMessage('ai', settings.greetingMessage);

            // Add quick replies if enabled
            if (settings.showQuickReplies === 'yes' && settings.quickReplies && settings.quickReplies.length) {
                showQuickReplies(settings.quickReplies);
            }
        }

        /**
         * Toggle the chat open/closed state (for floating chat)
         */
        function toggleChat() {
            if (settings.layoutType !== 'floating') return;
            
            state.chatOpen = !state.chatOpen;
            
            if (state.chatOpen) {
                container.style.display = 'flex';
                // Animate opening
                setTimeout(() => {
                    container.style.opacity = '1';
                    container.style.transform = 'translateY(0)';
                    
                    // Focus on input after opening
                    inputField.focus();
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
            
            // Create avatar
            const avatarEl = document.createElement('div');
            avatarEl.className = 'aiq-chat__avatar';
            
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
            
            // Announce typing to screen readers
            const srAnnounce = document.createElement('div');
            srAnnounce.className = 'sr-only';
            srAnnounce.setAttribute('aria-live', 'polite');
            srAnnounce.textContent = `${settings.aiName} is typing...`;
            widget.appendChild(srAnnounce);
            
            // Remove after announcement
            setTimeout(() => {
                widget.removeChild(srAnnounce);
            }, 1000);
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
            replies.forEach(reply => {
                const replyBtn = document.createElement('button');
                replyBtn.className = 'aiq-chat__quick-reply-btn';
                replyBtn.textContent = reply;
                replyBtn.setAttribute('type', 'button');
                
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
        }

        /**
         * Hide quick reply buttons
         */
        function hideQuickReplies() {
            quickRepliesContainer.style.display = 'none';
        }

        /**
         * Scroll messages container to bottom
         */
        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
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
