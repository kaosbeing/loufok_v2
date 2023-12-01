document.addEventListener("DOMContentLoaded", function () {
  function toggleMenu() {
    const menuContainer = document.querySelector(
      ".accessibility-menu__content"
    );
    menuContainer.style.display =
      menuContainer.style.display === "none" ? "flex" : "none";
  }
  // Function to set font size
  function setFontSize(size) {
    document.documentElement.style.fontSize = size + "px";
    localStorage.setItem("fontSize", size);
  }

  // Function to set font family
  function setFontFamily(fontFamily) {
    document.documentElement.style.fontFamily = fontFamily;
    localStorage.setItem("fontFamily", fontFamily);
  }

  // Function to load user preferences
  function loadPreferences() {
    const savedFontSize = localStorage.getItem("fontSize");
    const savedFontFamily = localStorage.getItem("fontFamily");

    if (savedFontSize) {
      setFontSize(savedFontSize);
    }

    if (savedFontFamily) {
      setFontFamily(savedFontFamily);
    }
  }

  // Event listener for font size increase button
  document
    .querySelector(".font-size--add")
    .addEventListener("click", function () {
      const currentSize = parseFloat(
        getComputedStyle(document.documentElement).fontSize
      );

      setFontSize(Math.min(currentSize + 2, 26));
    });

  // Event listener for font size decrease button
  document
    .querySelector(".font-size--sub")
    .addEventListener("click", function () {
      const currentSize = parseFloat(
        getComputedStyle(document.documentElement).fontSize
      );
      setFontSize(Math.max(currentSize - 2, 12)); // Ensure minimum font size is 10px
    });

  // Event listener for font family change button
  document
    .querySelector(".font-fam-change")
    .addEventListener("click", function () {
      document.documentElement.classList.toggle("dys");
      const isDyslexic = document.documentElement.classList.contains("dys");
      setFontFamily(isDyslexic ? "var(--dys)" : "var(--helvetica)");
    });
  document
    .querySelector(".accessibility-menu__button")
    .addEventListener("click", (e) => {
      if (!e.target.closest(".accessibility-menu__content")) {
        toggleMenu();
      }
    });
  document
    .querySelector(".accessibility-menu__button")
    .addEventListener("keypress", (e) => {
      if (!e.target.closest(".accessibility-menu__content")) {
        toggleMenu();
      }
    });
  // Load user preferences on page load
  loadPreferences();
});
