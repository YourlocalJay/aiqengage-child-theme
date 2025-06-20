/**
 * Feature Section Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

/* eslint-env jquery */
(function ($) {
  "use strict";

  var FeatureSection = function ($scope, $) {
    var $featureSection = $scope.find(".aiq-feature-section");
    var $cards = $featureSection.find(".aiq-feature-section__feature--card");

    // Initialize hover effects
    initHoverEffects();

    // Initialize animations when elements come into view
    initScrollAnimations();

    // Function to handle card hover effects
    function initHoverEffects() {
      if ($cards.length === 0) {
        return;
      }

      $cards.each(function () {
        var $card = $(this);

        $card.on("mouseenter", function () {
          $card.css("transform", "translateY(-3px)");
          $card.css("box-shadow", "0 8px 20px rgba(0, 0, 0, 0.4)");
        });

        $card.on("mouseleave", function () {
          $card.css("transform", "");
          $card.css("box-shadow", "");
        });
      });
    }

    // Function to handle scroll animations
    function initScrollAnimations() {
      if (!window.IntersectionObserver) {
        return;
      }

      var $features = $featureSection.find(".aiq-feature-section__feature");
      var $cta = $featureSection.find(".aiq-feature-section__cta");

      // Fade in features when they come into view
      var featuresObserver = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              var $feature = $(entry.target);
              var delay = $feature.index() * 100;

              setTimeout(function () {
                $feature.css({
                  opacity: "1",
                  transform: "translateY(0)",
                });
              }, delay);

              featuresObserver.unobserve(entry.target);
            }
          });
        },
        {
          threshold: 0.1,
        },
      );

      // Prepare features for animation
      $features.each(function () {
        $(this).css({
          opacity: "0",
          transform: "translateY(20px)",
          transition: "opacity 0.5s ease, transform 0.5s ease",
        });

        featuresObserver.observe(this);
      });

      // Fade in CTA when it comes into view
      if ($cta.length > 0) {
        var ctaObserver = new IntersectionObserver(
          function (entries) {
            entries.forEach(function (entry) {
              if (entry.isIntersecting) {
                $cta.css({
                  opacity: "1",
                  transform: "translateY(0)",
                });

                ctaObserver.unobserve(entry.target);
              }
            });
          },
          {
            threshold: 0.1,
          },
        );

        // Prepare CTA for animation
        $cta.css({
          opacity: "0",
          transform: "translateY(20px)",
          transition: "opacity 0.5s ease, transform 0.5s ease",
        });

        ctaObserver.observe($cta[0]);
      }
    }
  };

  // Make sure we initialize the widget when Elementor frontend is ready
  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/aiq_feature_section.default",
      FeatureSection,
    );
  });
})(jQuery);
