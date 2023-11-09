window.addEventListener("DOMContentLoaded", () => {
  const password = document.querySelector("#password");
  const checkbox = document.querySelector("#toggle-password");
  checkbox.addEventListener("click", function () {
    if (password.type === "password") {
      password.type = "text";
    } else {
      password.type = "password";
    }
  });
});
