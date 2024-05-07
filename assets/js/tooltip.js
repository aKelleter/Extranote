/* https://diogoredin.com/building-a-vanilla-javascript-css-tooltip/ */

const tooltips = document.querySelectorAll("[data-tooltip]");

const displayTooltip = (e) => {
  const trigger = e.target;
  const tooltip = trigger.querySelector("[role=tooltip]");

  const { x, y, width, height } = trigger.getBoundingClientRect();
  tooltip.style.left = `${Math.floor(x + width / 2)}px`;
  tooltip.style.top = `${Math.floor(y + height)}px`;

  tooltip.classList.add("active");
};

const hideTooltip = (e) => {
  const tooltip = e.target.querySelector("[role=tooltip]");
  tooltip.classList.remove("active");
};

const DELAY = 300;
let tooltipTimer = null;

tooltips.forEach((trigger) => {
  let tooltip = document.createElement("div");

  tooltip.setAttribute("role", "tooltip");
  tooltip.setAttribute("inert", true);
  tooltip.textContent = trigger.dataset.tooltip;

  trigger.appendChild(tooltip);

  trigger.addEventListener("mouseenter", (e) => {
    clearTimeout(tooltipTimer);

    tooltipTimer = setTimeout(() => {
      displayTooltip(e);
    }, DELAY);
  });

  trigger.addEventListener("mouseleave", (e) => {
    clearTimeout(tooltipTimer);
    hideTooltip(e);
  });
});
