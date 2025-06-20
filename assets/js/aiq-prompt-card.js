/**
 * AIQ Prompt Card Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 */

/* exported jQuery, elementorFrontend, aiqPromptCardConfig */

( function( $ ) {
    'use strict';

    const AIQPromptCard = {

        /**
         * Initialize all prompt cards
         */
        init: function() {
            this.cacheElements();
            this.bindEvents();
            this.setupIntersectionObserver();

            // Initialize any cards already in the DOM
            this.initPromptCards( $( '.aiq-prompt-card' ) );

            // Support for Elementor preview
            if ( typeof elementorFrontend !== 'undefined' ) {
                elementorFrontend.hooks.addAction( 'frontend/element_ready/aiq_prompt_card.default', function( $scope ) {
                    AIQPromptCard.initPromptCards( $scope.find( '.aiq-prompt-card' ) );
                } );
            }
        },

        /**
         * Cache frequently used elements
         */
        cacheElements: function() {
            this.cache = {
                $body: $( 'body' ),
                $announcer: $( '#aiq-screen-reader-announcer' )
            };
        },

        /**
         * Set up Intersection Observer for lazy loading
         */
        setupIntersectionObserver: function() {
            if ( 'IntersectionObserver' in window ) {
                this.observer = new IntersectionObserver( ( entries ) => {
                    entries.forEach( entry => {
                        if ( entry.isIntersecting ) {
                            this.handleCardVisibility( $( entry.target ) );
                            this.observer.unobserve( entry.target );
                        }
                    } );
                }, {
                    rootMargin: '200px',
                    threshold: 0.1
                } );
            }
        },

        /**
         * Handle card visibility
         */
        handleCardVisibility: function( $card ) {
            // Future implementation for lazy loading
            $card.addClass( 'aiq-prompt-card--visible' );
        },

        /**
         * Bind event handlers
         */
        bindEvents: function() {
            // Delegate events for dynamic content
            this.cache.$body.on(
                'click',
                '.aiq-prompt-card__toggle',
                this.handleToggleClick.bind( this )
            );

            this.cache.$body.on(
                'click',
                '.aiq-prompt-card__copy-btn',
                this.handleCopyClick.bind( this )
            );

            this.cache.$body.on(
                'click',
                '.aiq-prompt-card__variable-insert',
                this.handleVariableInsertClick.bind( this )
            );

            // Keyboard navigation
            this.cache.$body.on(
                'keydown',
                '.aiq-prompt-card__toggle, .aiq-prompt-card__copy-btn, .aiq-prompt-card__variable-insert',
                this.handleKeyDown.bind( this )
            );
        },

        /**
         * Initialize prompt cards
         */
        initPromptCards: function( $cards ) {
            $cards.each( ( index, card ) => {
                const $card = $( card );

                // Set up Intersection Observer if available
                if ( this.observer ) {
                    this.observer.observe( card );
                } else {
                    this.handleCardVisibility( $card );
                }

                // Initialize tooltips
                this.initTooltips( $card );
            } );
        },

        /**
         * Initialize tooltips
         */
        initTooltips: function( $card ) {
            // Future implementation for tooltips
        },

        /**
         * Handle toggle click
         */
        handleToggleClick: function( e ) {
            e.preventDefault();
            const $button = $( e.currentTarget );
            const $card = $button.closest( '.aiq-prompt-card' );

            $card.toggleClass( 'aiq-prompt-card--expanded' );

            // Update ARIA attributes
            const isExpanded = $card.hasClass( 'aiq-prompt-card--expanded' );
            $button.attr( 'aria-expanded', isExpanded );

            // Focus management
            if ( isExpanded ) {
                const $content = $card.find( '.aiq-prompt-card__content' );
                $content.attr( 'tabindex', '-1' ).focus();
            }
        },

        /**
         * Handle copy click
         */
        handleCopyClick: function( e ) {
            e.preventDefault();
            const $button = $( e.currentTarget );
            const $card = $button.closest( '.aiq-prompt-card' );
            const promptText = $card.find( '.aiq-prompt-card__prompt' ).text();

            this.copyToClipboard( promptText )
                .then( () => {
                    this.showCopiedMessage( $card );
                    this.announceForScreenReaders( aiqPromptCardConfig.i18n.copied );
                } )
                .catch( ( err ) => {
                    if (window?.aiqPromptCardDebug) {
                        console.error( 'Failed to copy:', err );
                    }
                    this.announceForScreenReaders( aiqPromptCardConfig.i18n.error );
                } );
        },

        /**
         * Handle variable insert click
         */
        handleVariableInsertClick: function( e ) {
            e.preventDefault();
            const $button = $( e.currentTarget );
            const variableName = $button.data( 'variable' );
            const promptId = $button.data( 'prompt-id' );
            const $card = $( '#' + promptId );

            this.copyToClipboard( variableName )
                .then( () => {
                    this.highlightVariable( $card, variableName );
                    this.announceForScreenReaders(
                        aiqPromptCardConfig.i18n.variable_copied.replace( '%s', variableName )
                    );
                } )
                .catch( ( err ) => {
                    if (window?.aiqPromptCardDebug) {
                        console.error( 'Failed to copy variable:', err );
                    }
                    this.announceForScreenReaders( aiqPromptCardConfig.i18n.error );
                } );
        },

        /**
         * Handle keyboard navigation
         */
        handleKeyDown: function( e ) {
            const $button = $( e.currentTarget );

            // Space or Enter triggers click
            if ( e.key === ' ' || e.key === 'Enter' ) {
                e.preventDefault();
                $button.trigger( 'click' );
            }
        },

        /**
         * Copy text to clipboard
         */
        copyToClipboard: function( text ) {
            if ( navigator.clipboard && window.isSecureContext ) {
                return navigator.clipboard.writeText( text );
            } else {
                // Fallback for older browsers
                return new Promise( ( resolve, reject ) => {
                    try {
                        const $temp = $( '<textarea>' ).val( text ).css( {
                            position: 'fixed',
                            opacity: 0,
                            left: '-9999px'
                        } ).appendTo( this.cache.$body );

                        $temp.select();
                        document.execCommand( 'copy' );
                        $temp.remove();
                        resolve();
                    } catch ( err ) {
                        reject( err );
                    }
                } );
            }
        },

        /**
         * Show copied message
         */
        showCopiedMessage: function( $card ) {
            $card.addClass( 'aiq-prompt-card--copied' );

            // Hide after delay
            setTimeout( () => {
                $card.removeClass( 'aiq-prompt-card--copied' );
            }, 2000 );
        },

        /**
         * Highlight variable in prompt
         */
        highlightVariable: function( $card, variableName ) {
            const $promptText = $card.find( '.aiq-prompt-card__prompt' );
            const html = $promptText.html();
            const regex = new RegExp( this.escapeRegExp( variableName ), 'g' );
            const highlightedHtml = html.replace(
                regex,
                '<span class="aiq-prompt-card__variable-highlight">$&</span>'
            );

            $promptText.html( highlightedHtml );

            // Remove highlighting after delay
            setTimeout( () => {
                $promptText.html( html );
            }, 2000 );
        },

        /**
         * Escape special regex characters
         */
        escapeRegExp: function( string ) {
            return string.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' );
        },

        /**
         * Announce message to screen readers
         */
        announceForScreenReaders: function( message ) {
            if ( ! this.cache.$announcer.length ) {
                this.cache.$announcer = $( '<div>', {
                    id: 'aiq-screen-reader-announcer',
                    'aria-live': 'polite',
                    'aria-atomic': 'true',
                    class: 'sr-only'
                } ).appendTo( this.cache.$body );
            }

            this.cache.$announcer.text( message );

            // Clear after delay
            setTimeout( () => {
                this.cache.$announcer.text( '' );
            }, 3000 );
        }
    };

    // Initialize when DOM is ready
    $( document ).ready( function() {
        AIQPromptCard.init();
    } );

} )( jQuery );
