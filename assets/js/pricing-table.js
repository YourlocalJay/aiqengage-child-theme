/**
 * Pricing Table Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

(function ($) {
  "use strict";

  // TODO: Implement Pricing Table widget functionality
  $(document).ready(function () {
    $(".aiq-pricing-table").each(function () {
      const $widget = $(this);

      // Initialize pricing table functionality
      initPricingTable($widget);
    });
  });

  function initPricingTable($widget) {
    // Add hover effects and interactive features
    const $pricingCards = $widget.find(".aiq-pricing-table__card");

    $pricingCards
      .on("mouseenter", function () {
        $(this).addClass("is-highlighted");
      })
      .on("mouseleave", function () {
        $(this).removeClass("is-highlighted");
      });

    // Handle CTA button clicks
    $widget.find(".aiq-pricing-table__cta").on("click", function () {
      // Add click tracking or animations here
      const $thisCard = $(this).closest(".aiq-pricing-table__card");
      $thisCard.addClass("is-clicked");

      setTimeout(() => {
        $thisCard.removeClass("is-clicked");
      }, 200);
    });
  }
})(jQuery);
