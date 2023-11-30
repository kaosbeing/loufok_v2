const switch_current = document.querySelector(".switch-button.activated");
const switch_old = document.querySelector(".switch-button:not(.activated)");
const current = document.querySelector(".current");
const old = document.querySelector(".old");
function switcher(type) {
  if (type == "current") {
    switch_current.classList.add("activated");
    switch_old.classList.remove("activated");
    current.classList.remove("d-none");
    old.classList.add("d-none");
    switch_current.ariaSelected = true;
    switch_old.ariaSelected = false;
  }
  if (type == "old") {
    switch_old.classList.add("activated");
    switch_current.classList.remove("activated");
    old.classList.remove("d-none");
    current.classList.add("d-none");
    switch_old.ariaSelected = true;
    switch_current.ariaSelected = false;
  }
}

switch_current.addEventListener("click", () => {
  switcher("current");
});
switch_current.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    switcher("current");
  }
});

switch_old.addEventListener("click", () => {
  switcher("old");
});
switch_old.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    switcher("old");
  }
});
