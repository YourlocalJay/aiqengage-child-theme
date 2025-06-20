/**
 * Blueprint Flow Widget Script
 *
 * @package aiqengage-child
 * @version   1.0.0
 * @since     1.0.0
 * @author    Jason
 */

(function ($) {
  "use strict";

  /**
   * Initialize Blueprint Flow Widget
   */
  var initBlueprintFlow = function () {
    // Node Highlighting
    initNodeHighlighting();

    // ROI Calculator
    initRoiCalculator();
  };

  /**
   * Initialize Node Highlighting
   */
  var initNodeHighlighting = function () {
    $(".aiq-blueprint-flow__node")
      .on("mouseenter focus", function () {
        $(this).addClass("is-active");
      })
      .on("mouseleave blur", function () {
        $(this).removeClass("is-active");
      });

    // Optional: Add interactive highlighting on click
    $(".aiq-blueprint-flow__node").on("click", function () {
      var $nodes = $(".aiq-blueprint-flow__node");
      var $connectors = $(".aiq-blueprint-flow__connector");

      if ($(this).hasClass("is-selected")) {
        // Deselect if already selected
        $nodes.removeClass("is-selected is-before is-after");
        $connectors.removeClass("is-selected is-before is-after");
      } else {
        // Select this node
        $nodes.removeClass("is-selected is-before is-after");
        $connectors.removeClass("is-selected is-before is-after");

        $(this).addClass("is-selected");

        // Mark nodes before and after the selected node
        var $flowNodes = $(this).closest(".aiq-blueprint-flow__nodes");
        var $allNodes = $flowNodes.find(".aiq-blueprint-flow__node");
        var $allConnectors = $flowNodes.find(".aiq-blueprint-flow__connector");
        var currentIndex = $allNodes.index(this);

        $allNodes.each(function (index) {
          if (index < currentIndex) {
            $(this).addClass("is-before");
          } else if (index > currentIndex) {
            $(this).addClass("is-after");
          }
        });

        $allConnectors.each(function (index) {
          if (index < currentIndex) {
            $(this).addClass("is-before");
          } else {
            $(this).addClass("is-after");
          }
        });
      }
    });
  };

  /**
   * Initialize ROI Calculator
   */
  var initRoiCalculator = function () {
    $(".aiq-blueprint-flow__roi-form").each(function () {
      var $form = $(this);
      var formulaType = $form.data("formula");
      var customFormula = "";

      // Get custom formula if present
      if (formulaType === "custom") {
        var $formulaScript = $form.find(
          ".aiq-blueprint-flow__roi-custom-formula",
        );
        if ($formulaScript.length) {
          customFormula = $formulaScript.html();
        }
      }

      // Handle input changes
      $form
        .find(".aiq-blueprint-flow__roi-input, .aiq-blueprint-flow__roi-slider")
        .on("input change", function () {
          updateCalculation($form, formulaType, customFormula);
        });

      // Handle slider value display
      $form.find(".aiq-blueprint-flow__roi-slider").on("input", function () {
        var $slider = $(this);
        var value = $slider.val();

        // Check if this is a percentage field
        var isPercentage = $slider
          .closest(".aiq-blueprint-flow__roi-field")
          .find(".aiq-blueprint-flow__roi-slider-value")
          .text()
          .includes("%");

        // Update the display value
        $slider
          .closest(".aiq-blueprint-flow__roi-slider-container")
          .find(".aiq-blueprint-flow__roi-slider-value")
          .text(value + (isPercentage ? "%" : ""));
      });

      // Initial calculation
      updateCalculation($form, formulaType, customFormula);
    });
  };

  /**
   * Update ROI Calculation
   *
   * @param {jQuery} $form The form element
   * @param {string} formulaType The type of formula to use
   * @param {string} customFormula Custom formula (if applicable)
   */
  var updateCalculation = function ($form, formulaType, customFormula) {
    var fieldValues = [];

    // Collect all field values
    $form
      .find(".aiq-blueprint-flow__roi-input, .aiq-blueprint-flow__roi-slider")
      .each(function () {
        var value = parseFloat($(this).val()) || 0;
        fieldValues.push(value);
      });

    var result = 0;

    // Calculate result based on formula type
    if (formulaType === "traffic_conversion_value" && fieldValues.length >= 3) {
      // Traffic × Conversion × Value
      result = fieldValues[0] * (fieldValues[1] / 100) * fieldValues[2];
    } else if (formulaType === "custom" && customFormula) {
      try {
        // Use Function constructor to safely evaluate the custom formula
        var calculateFunction = new Function("fieldValues", customFormula);
        result = calculateFunction(fieldValues);
      } catch (error) {
        console.error("Error in custom formula:", error);
        result = 0;
      }
    }

    // Format the result
    var formattedResult = formatCurrency(result);

    // Update the result display.
    $form.find(".aiq-blueprint-flow__roi-value").text(formattedResult);
  };

  /**
   * Format a number as currency
   *
   * @param {number} value The value to format
   * @return {string} Formatted currency string
   */
  var formatCurrency = function (value) {
    // Round to 2 decimal places
    value = Math.round(value * 100) / 100;

    // Format with commas for thousands
    return (
      "$" +
      value.toLocaleString("en-US", {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
      })
    );
  };

  // Initialize on document ready
  $(document).ready(function () {
    initBlueprintFlow();
  });

  // Initialize on Elementor frontend init
  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/aiq_blueprint_flow.default",
      initBlueprintFlow,
    );
  });
})(jQuery);
