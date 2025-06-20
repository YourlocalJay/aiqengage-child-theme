/* global */
/**
 * ROI Calculator Widget Script
 *
 * @package aiqengage-child
 * @version 1.0.0
 * @since   1.0.0
 * @author  Jason
 */

class ROICalculator {
  constructor(container) {
    this.container = container;
    this.form = container.querySelector(".aiq-roi-calculator__form");
    this.results = container.querySelector(".aiq-roi-calculator__results");
    this.init();
  }

  init() {
    this.cacheElements();
    this.bindEvents();
    this.calculate(); // Initial calculation
  }

  cacheElements() {
    this.elements = {
      monthlyRevenue: this.container.querySelector('[data-result="monthly"]'),
      totalRevenue: this.container.querySelector('[data-result="total"]'),
      // Cache other result elements
      profit: this.container.querySelector('[data-result="profit"]'),
      roi: this.container.querySelector('[data-result="roi"]'),
      breakeven: this.container.querySelector('[data-result="breakeven"]'),
    };
  }

  bindEvents() {
    // Form submission
    this.form.addEventListener("submit", (e) => {
      e.preventDefault();
      this.calculate();
    });

    // Input changes
    this.form.querySelectorAll("input").forEach((input) => {
      input.addEventListener(
        "input",
        this.debounce(() => this.calculate(), 300),
      );
    });

    // Reset form
    this.form
      .querySelector('button[type="reset"]')
      .addEventListener("click", () => {
        setTimeout(() => this.calculate(), 100);
      });
  }

  getFormData() {
    return {
      traffic: parseFloat(this.form.traffic.value) || 0,
      conversion: parseFloat(this.form.conversion.value) || 0,
      aov: parseFloat(this.form.aov.value) || 0,
      affiliate: parseFloat(this.form.affiliate.value) / 100 || 0,
      cost: parseFloat(this.form.cost.value) || 0,
      months: parseInt(this.form.months.value) || 1,
    };
  }

  calculate() {
    const { traffic, conversion, aov, affiliate, cost, months } =
      this.getFormData();

    // Calculations
    const dailyRevenue = traffic * (conversion / 100) * aov * affiliate;
    const monthlyRevenue = dailyRevenue * 30;
    const totalRevenue = monthlyRevenue * months;
    const netProfit = totalRevenue - cost;
    const roi = cost ? Math.round((netProfit / cost) * 100) : 0;
    const breakEven = dailyRevenue ? Math.ceil(cost / dailyRevenue) : 0;

    // Update UI
    this.updateResults({
      monthly: monthlyRevenue,
      total: totalRevenue,
      profit: netProfit,
      roi,
      breakeven: breakEven,
    });
  }

  updateResults(data) {
    // Format currency
    const formatCurrency = (value) => {
      return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(value);
    };

    // Update each result element
    this.elements.monthlyRevenue.textContent = formatCurrency(data.monthly);
    this.elements.totalRevenue.textContent = formatCurrency(data.total);
    // Update other elements...
    this.elements.profit.textContent = formatCurrency(data.profit);
    this.elements.roi.textContent = `${data.roi}%`;
    this.elements.breakeven.textContent = `${data.breakeven} days`;
  }

  debounce(func, wait) {
    let timeout;
    return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  }
}

// Initialize all calculators on the page
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".aiq-roi-calculator").forEach((container) => {
    new ROICalculator(container);
  });
});
