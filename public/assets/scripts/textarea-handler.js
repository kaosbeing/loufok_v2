const form = document.querySelector(".form");
const contrib = document.querySelector(".form__textarea");
if (form) {
  let nbCharac = contrib.value.length;

  // Create a span element, position absolute into the form textarea
  let lengthIndicator = document.createElement("span");
  lengthIndicator.style.fontSize = "0.8rem";
  lengthIndicator.style.position = "absolute";
  lengthIndicator.style.right = "0.25rem";
  lengthIndicator.style.textAlign = "right";
  lengthIndicator.style.top = "50%";
  lengthIndicator.style.transform = "translateY(-50%)";

  if (contrib != null) {
    contrib.parentNode.appendChild(lengthIndicator); // Appends the string limit indicator to the textarea
    // Both these function are called AFTER the draft is injected in textarea
    // Autoresize is in settimeout because there was a bug where it was a not the right size on load
    displayCharLimits();
    setTimeout(() => {
      autoResize();
    }, 50);

    contrib.addEventListener("input", () => {
      nbCharac = contrib.value.length;

      displayCharLimits();
      autoResize();
    });
  }

  function autoResize() {
    contrib.style.height = "auto"; // Reset the height to auto to determine the natural height
    contrib.style.height = contrib.scrollHeight + "px"; // Set the height to match the content height
  }

  function displayCharLimits() {
    if (nbCharac < 50) {
      lengthIndicator.innerText = nbCharac - 50;
      lengthIndicator.style.color = "red";
    } else {
      lengthIndicator.innerText = 280 - nbCharac;

      if (nbCharac > 280) {
        lengthIndicator.style.color = "red";
      } else {
        lengthIndicator.style.color = "green";
      }
    }
  }
}
