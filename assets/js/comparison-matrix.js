/**
 * Comparison Matrix Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 */

(function($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function() {
        initComparisonMatrix();
    });

    // Initialize on Elementor frontend init
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/aiq_comparison_matrix.default', initComparisonMatrix);
    });

    /**
     * Initialize Comparison Matrix functionality
     */
    function initComparisonMatrix() {
        const $matrices = $('.aiq-comparison-matrix-wrapper');

        if (!$matrices.length) return;

        $matrices.each(function() {
            const $matrix = $(this);

            // Highlight differences if enabled
            if ($matrix.data('highlight-differences') === true) {
                highlightDifferences($matrix);
            }

            // Enable sorting if enabled
            if ($matrix.data('enable-sorting') === true) {
                setupSorting($matrix);
            }

            // Setup tooltip behavior
            setupTooltips($matrix);

            // Setup responsive behavior
            setupResponsiveBehavior($matrix);

            // Setup accessibility
            setupAccessibility($matrix);
        });
    }

    /**
     * Highlight differences between columns
     */
    function highlightDifferences($matrix) {
        const $rows = $matrix.find('.aiq-comparison-matrix__row:not(.aiq-comparison-matrix__header):not(.aiq-comparison-matrix__row--category):not(.aiq-comparison-matrix__row--cta)');

        $rows.each(function() {
            const $row = $(this);
            const $cells = $row.find('.aiq-comparison-matrix__cell:not(.aiq-comparison-matrix__feature)');

            // Analyze cells to find differences
            let cellValues = [];
            let allSame = true;

            // Collect cell contents for comparison
            $cells.each(function() {
                const $cell = $(this);
                let value;

                // Determine value based on cell type
                if ($cell.find('.fa-check').length) {
                    value = 'yes';
                } else if ($cell.find('.fa-times').length) {
                    value = 'no';
                } else if ($cell.find('.aiq-comparison-matrix__rating').length) {
                    value = $cell.find('.aiq-comparison-matrix__rating').data('rating');
                } else {
                    value = $cell.text().trim();
                }

                cellValues.push(value);

                // Check if we have differences
                if (cellValues.length > 1 && value !== cellValues[0]) {
                    allSame = false;
                }
            });

            // If not all the same, highlight the differences
            if (!allSame) {
                // Find the most common value
                const valueCount = {};
                let mostCommonValue;
                let maxCount = 0;

                cellValues.forEach(value => {
                    valueCount[value] = (valueCount[value] || 0) + 1;
                    if (valueCount[value] > maxCount) {
                        maxCount = valueCount[value];
                        mostCommonValue = value;
                    }
                });

                // Highlight cells that are different from the most common value
                $cells.each(function(index) {
                    if (cellValues[index] !== mostCommonValue) {
                        $(this).addClass('aiq-comparison-matrix__cell--highlight');
                    }
                });
            }
        });
    }

    /**
     * Setup interactive sorting functionality
     */
    function setupSorting($matrix) {
        // Create sort controls
        const $sortControl = $('<div class="aiq-comparison-matrix__sort-control"></div>');
        const $sortLabel = $('<span class="aiq-comparison-matrix__sort-label">Sort by: </span>');
        const $sortSelect = $('<select class="aiq-comparison-matrix__sort-select"></select>');

        // Add default option
        $sortSelect.append('<option value="default">Default Order</option>');

        // Add options for each row that's not a category or header
        const $rows = $matrix.find('.aiq-comparison-matrix__row:not(.aiq-comparison-matrix__header):not(.aiq-comparison-matrix__row--category):not(.aiq-comparison-matrix__row--cta)');

        $rows.each(function(index) {
            const rowName = $(this).find('.aiq-comparison-matrix__feature').text().trim();
            $sortSelect.append(`<option value="row-${index}">${rowName}</option>`);
        });

        // Append controls
        $sortControl.append($sortLabel).append($sortSelect);
        $matrix.prepend($sortControl);

        // Handle sorting on change
        $sortSelect.on('change', function() {
            const selectedValue = $(this).val();

            if (selectedValue === 'default') {
                // Reset to default order
                resetMatrixOrder($matrix);
                return;
            }

            // Extract row index from the value (format: row-{index})
            const rowIndex = parseInt(selectedValue.split('-')[1]);
            const $targetRow = $rows.eq(rowIndex);

        const columnValues = [];

            // Get values for the target row in each column
            $targetRow.find('.aiq-comparison-matrix__cell').not('.aiq-comparison-matrix__feature').each(function(colIndex) {
                let value;

                // Determine value based on cell type
                if ($(this).find('.fa-check').length) {
                    value = 1;
                } else if ($(this).find('.fa-times').length) {
                    value = 0;
                } else if ($(this).find('.aiq-comparison-matrix__rating').length) {
                    value = $(this).find('.aiq-comparison-matrix__rating').data('rating');
                } else if (!isNaN(parseFloat($(this).text().trim()))) {
                    value = parseFloat($(this).text().trim());
                } else {
                    value = $(this).text().trim();
                }

                columnValues.push({
                    index: colIndex,
                    value: value
                });
            });

            // Sort columns by the values
            columnValues.sort((a, b) => {
                if (typeof a.value === 'string' && typeof b.value === 'string') {
                    return a.value.localeCompare(b.value);
                } else {
                    return b.value - a.value; // Descending order for numbers
                }
            });

            // Reorder columns based on the sorted values
            reorderColumns($matrix, columnValues.map(item => item.index + 1)); // +1 to account for feature column
        });
    }

    /**
     * Reset matrix to its default column order
     */
    function resetMatrixOrder($matrix) {
        // Get all columns including the feature column
        const $columns = $matrix.find('.aiq-comparison-matrix__cell');

        // Reset the order by clearing any applied order styles
        $columns.css('order', '');
    }

    /**
     * Reorder matrix columns based on provided order
     */
    function reorderColumns($matrix, columnOrder) {
        // Make the matrix a CSS grid for easier column reordering
        const $matrixTable = $matrix.find('.aiq-comparison-matrix');
        const columnCount = columnOrder.length + 1; // +1 for feature column

        // Apply flex display to rows
        $matrixTable.css({
            'display': 'flex',
            'flex-direction': 'column'
        });

        $matrixTable.find('.aiq-comparison-matrix__row').css({
            'display': 'flex',
            'width': '100%'
        });

        // Apply flex grow to cells
        $matrixTable.find('.aiq-comparison-matrix__cell').css({
            'flex': '1',
            'min-width': '0'
        });

        // Set the feature column to order 0 (first)
        $matrixTable.find('.aiq-comparison-matrix__feature, .aiq-comparison-matrix__feature-header').css('order', '0');

        // Set order for other columns
        $matrixTable.find('.aiq-comparison-matrix__row').each(function() {
            const $cells = $(this).find('.aiq-comparison-matrix__cell').not('.aiq-comparison-matrix__feature, .aiq-comparison-matrix__feature-header');

            columnOrder.forEach((newOrder, originalIndex) => {
                $cells.eq(originalIndex).css('order', newOrder);
            });
        });
    }

    /**
     * Setup tooltip behavior for better UX
     */
    function setupTooltips($matrix) {
        // Ensure tooltips are keyboard accessible
        const $tooltips = $matrix.find('.aiq-comparison-matrix__tooltip');

        $tooltips.each(function() {
            const $tooltip = $(this);
            const $icon = $tooltip.find('.aiq-comparison-matrix__tooltip-icon');

            // Make tooltip focusable
            $icon.attr('tabindex', '0');
            $icon.attr('role', 'button');
            $icon.attr('aria-label', 'Show more information');

            // Show tooltip on focus as well as hover
            $icon.on('focus mouseenter', function() {
                $tooltip.find('.aiq-comparison-matrix__tooltip-content').css({
                    'visibility': 'visible',
                    'opacity': '1'
                });
            });

            // Hide tooltip on blur and mouse leave
            $icon.on('blur mouseleave', function() {
                $tooltip.find('.aiq-comparison-matrix__tooltip-content').css({
                    'visibility': 'hidden',
                    'opacity': '0'
                });
            });

            // Toggle tooltip on space/enter key
            $icon.on('keydown', function(e) {
                if (e.key === ' ' || e.key === 'Enter') {
                    e.preventDefault();

                    const $content = $tooltip.find('.aiq-comparison-matrix__tooltip-content');
                    const isVisible = $content.css('visibility') === 'visible';

                    if (isVisible) {
                        $content.css({
                            'visibility': 'hidden',
                            'opacity': '0'
                        });
                    } else {
                        $content.css({
                            'visibility': 'visible',
                            'opacity': '1'
                        });
                    }
                }
            });
        });
    }

    /**
     * Setup responsive behavior
     */
    function setupResponsiveBehavior($matrix) {
        // Add horizontal scroll indicators if needed
        const $wrapper = $matrix;
        const $table = $wrapper.find('.aiq-comparison-matrix');

        // Only add indicators if table is wider than wrapper
        if ($table.width() > $wrapper.width()) {
            // Add scroll indicators
            const $scrollLeft = $('<div class="aiq-comparison-matrix__scroll-indicator aiq-comparison-matrix__scroll-indicator--left"><i class="fas fa-chevron-left"></i></div>');
            const $scrollRight = $('<div class="aiq-comparison-matrix__scroll-indicator aiq-comparison-matrix__scroll-indicator--right"><i class="fas fa-chevron-right"></i></div>');

            $wrapper.append($scrollLeft).append($scrollRight);

            // Show/hide indicators based on scroll position
            $wrapper.on('scroll', function() {
                const scrollLeft = $wrapper.scrollLeft();
                const maxScroll = $table.width() - $wrapper.width();

                if (scrollLeft === 0) {
                    $scrollLeft.hide();
                } else {
                    $scrollLeft.show();
                }

                if (scrollLeft >= maxScroll - 5) {
                    $scrollRight.hide();
                } else {
                    $scrollRight.show();
                }
            });

            // Trigger initial scroll event
            $wrapper.trigger('scroll');

            // Add click handlers for scroll indicators
            $scrollLeft.on('click', function() {
                $wrapper.animate({
                    scrollLeft: '-=200'
                }, 300);
            });

            $scrollRight.on('click', function() {
                $wrapper.animate({
                    scrollLeft: '+=200'
                }, 300);
            });
        }

        // Handle window resize
        $(window).on('resize', function() {
            if ($table.width() > $wrapper.width()) {
                // Show indicators if needed
                $wrapper.find('.aiq-comparison-matrix__scroll-indicator').show();
            } else {
                // Hide indicators if not needed
                $wrapper.find('.aiq-comparison-matrix__scroll-indicator').hide();
            }

            // Trigger scroll event to update indicator visibility
            $wrapper.trigger('scroll');
        });
    }

    /**
     * Setup accessibility features
     */
    function setupAccessibility($matrix) {
        // Add appropriate ARIA roles
        $matrix.find('.aiq-comparison-matrix').attr('role', 'table');
        $matrix.find('.aiq-comparison-matrix__row').attr('role', 'row');
        $matrix.find('.aiq-comparison-matrix__feature').attr('role', 'rowheader');
        $matrix.find('.aiq-comparison-matrix__header').attr('role', 'columnheader');
        $matrix.find('.aiq-comparison-matrix__cell').not('.aiq-comparison-matrix__feature, .aiq-comparison-matrix__header').attr('role', 'cell');

        // Add screen reader text for yes/no cells
        $matrix.find('.aiq-comparison-matrix__cell--yes').each(function() {
            if (!$(this).find('.elementor-screen-only').length) {
                $(this).append('<span class="elementor-screen-only">Yes</span>');
            }
        });

        $matrix.find('.aiq-comparison-matrix__cell--no').each(function() {
            if (!$(this).find('.elementor-screen-only').length) {
                $(this).append('<span class="elementor-screen-only">No</span>');
            }
        });

        // Make sure the table is navigable by keyboard
        $matrix.find('.aiq-comparison-matrix__cell a, .aiq-comparison-matrix__cta').attr('tabindex', '0');

        // Ensure tooltips are accessible (already handled in setupTooltips)
    }

})(jQuery);
