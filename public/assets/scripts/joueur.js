window.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".form");
  const contrib = document.querySelector(".form__textarea");
  const errors_span = document.querySelector(".errors");
  if (form) {
    form.addEventListener("submit", (e) => {
      let errors = [];
      if (contrib.value.length < 50) {
        errors.push("La contribution est trop courte.");
        console.log("1");
      }
      if (contrib.value.length > 280) {
        errors.push("La contribution est trop longue.");
        console.log("2");
      }
      if (errors.length != [].length) {
        errors.forEach((error) => {
          errors_span.innerText += error;
        });
        e.preventDefault();
      }
    });
  }
});
