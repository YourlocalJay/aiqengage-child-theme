/**
 * Prompt Card Widget - Enhanced JavaScript
 *
 * @package AIQEngage
 * @version 1.0.0
 */

( function( $ ) {
    'use strict';
    
    /**
     * Initialize Prompt Card functionality
     */
    function initPromptCards() {
        // Toggle expand/collapse
        $( document ).on( 'click', '.aiq-prompt-card__toggle', function() {
            const $card = $( this ).closest( '.aiq-prompt-card' );
            $card.toggleClass( 'aiq-prompt-card--expanded' );
            
            // Update aria-expanded attribute
            const isExpanded = $card.hasClass( 'aiq-prompt-card--expanded' );
            $( this ).attr( 'aria-expanded', isExpanded );
            
            // If expanded, focus on the prompt content
            if ( isExpanded ) {
                setTimeout( () => {
                    $card.find( '.aiq-prompt-card__prompt' ).attr( 'tabindex', '-1' ).focus();
                }, 300 );
            }
        });
        
        // Copy to clipboard functionality
        $( document ).on( 'click', '.aiq-prompt-card__copy-btn', function( e ) {
            e.preventDefault();
            const $card = $( this ).closest( '.aiq-prompt-card' );
            const $promptText = $card.find( '.aiq-prompt-card__prompt' );
            const textToCopy = $promptText.text().trim();
            
            copyToClipboard( textToCopy ).then( () => {
                showCopiedMessage( $card );
                announceForScreenReaders( 'Prompt copied to clipboard' );
            }).catch( ( err ) => {
                console.error( 'Failed to copy: ', err );
                alert( 'Failed to copy the prompt. Please try again.' );
            });
        });
        
        // Variable insert functionality
        $( document ).on( 'click', '.aiq-prompt-card__variable-insert', function( e ) {
            e.preventDefault();
            const variableName = $( this ).data( 'variable' );
            const promptId = $( this ).data( 'prompt-id' );
            const $card = $( '#' + promptId );
            const $promptText = $card.find( '.aiq-prompt-card__prompt' );
            
            copyToClipboard( variableName ).then( () => {
                highlightVariableInPrompt( $promptText, variableName );
                announceForScreenReaders( 'Variable ' + variableName + ' copied to clipboard' );
            }).catch( ( err ) => {
                console.error( 'Failed to copy variable: ', err );
                alert( 'Failed to copy the variable. Please try again.' );
            });
        });
    }
    
    /**
     * Copy text to clipboard using modern API with fallback
     * 
     * @param {string} text - The text to copy
     * @return {Promise} A promise that resolves when copy is complete
     */
    function copyToClipboard( text ) {
        // Use modern clipboard API if available
        if ( navigator.clipboard && window.isSecureContext ) {
            return navigator.clipboard.writeText( text );
        }
        
        // Fallback for older browsers
        return new Promise( ( resolve, reject ) => {
            try {
                const $temp = $( '<textarea>' );
                $( 'body' ).append( $temp );
                $temp.val( text ).select();
                
                const success = document.execCommand( 'copy' );
                $temp.remove();
                
                if ( success ) {
                    resolve();
                } else {
                    reject( new Error( 'execCommand copy failed' ) );
                }
            } catch ( err ) {
                reject( err );
            }
        });
    }
    
    /**
     * Show the "Copied" message
     * 
     * @param {jQuery} $card - The card element
     */
    function showCopiedMessage( $card ) {
        $card.addClass( 'aiq-prompt-card--copied' );
        
        // Hide message after 2 seconds
        setTimeout( () => {
            $card.removeClass( 'aiq-prompt-card--copied' );
        }, 2000 );
    }
    
    /**
     * Highlight a variable in the prompt text
     * 
     * @param {jQuery} $promptText - The prompt text element
     * @param {string} variableName - The variable name to highlight
     */
    function highlightVariableInPrompt( $promptText, variableName ) {
        const html = $promptText.html();
        const regex = new RegExp
