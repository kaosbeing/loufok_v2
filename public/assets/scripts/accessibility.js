window.addEventListener("DOMContentLoaded", () => {
  const menu = document.querySelector(".accessibility-menu");
  const button_sub = document.querySelector(".font-size--sub");
  const button_add = document.querySelector(".font-size--add");
  const button_change = document.querySelector(".font-fam-change");
  let currentFont = "helvetica";

  function changeFontSize(step) {
    const root = document.documentElement;
    const currentSize = parseInt(getComputedStyle(root).fontSize);
    const newSize = Math.min(24, Math.max(8, currentSize + step));
    root.style.fontSize = `${newSize}px`;
  }

  function toggleMenu() {
    const menuContainer = document.querySelector(
      ".accessibility-menu__content"
    );
    menuContainer.style.display =
      menuContainer.style.display === "none" ? "flex" : "none";
    menuContainer.classList.toggle("show"); // Toggle the 'show' class
  }

  function changeFontFamily() {
    const root = document.documentElement;
    const currentFont = localStorage.getItem("fontPreference") || "helvetica";
    const newFont = currentFont === "helvetica" ? "--dys" : "--helvetica";

    root.classList.toggle("dys");
    localStorage.setItem(
      "fontPreference",
      currentFont === "helvetica" ? "dys" : "helvetica"
    );
  }

  menu.addEventListener("click", (e) => {
    if (!e.target.closest(".accessibility-menu__content")) {
      toggleMenu();
    }
  });
  button_sub.addEventListener("click", () => {
    changeFontSize(-1);
  });
  button_add.addEventListener("click", () => {
    changeFontSize(1);
  });
  button_change.addEventListener("click", () => {
    changeFontFamily();
  });
});
