window.addEventListener("DOMContentLoaded", () => {
  const contrib = document.querySelector(".contribution__input");
  if (contrib != null) {
    contrib.addEventListener("input", () => {
      contrib.style.height = "auto";
      contrib.style.height = contrib.scrollHeight + 16 + "px";
    });
  }
});
