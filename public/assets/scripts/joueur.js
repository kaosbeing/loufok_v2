window.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".form");
  const contrib = document.querySelector(".form__textarea");
  const errors_span = document.querySelector(".errors");
  form.addEventListener("submit", (e) => {
    let errors = [];
    if (contrib.value.length < 50) {
      errors.push("La contribution est trop courte.");
    }
    if (contrib.value.length > 280) {
      errors.push("La contribution est trop longue.");
    }
    if (errors != []) {
      errors.forEach((error) => {
        errors_span.innerText += error;
      });
      e.preventDefault();
    }
  });
});
