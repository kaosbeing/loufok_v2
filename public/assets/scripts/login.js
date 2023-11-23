window.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".form--login");
  const email = document.querySelector(".email");
  let local_email = localStorage.getItem("email");
  if (local_email != null) {
    email.value = local_email;
  }
  form.addEventListener("submit", () => {
    localStorage.setItem("email", email.value);
  });
});
