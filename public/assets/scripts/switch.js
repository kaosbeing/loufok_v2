const switch_current = document.querySelector(".switch-button.activated");
const switch_old = document.querySelector(".switch-button:not(.activated)");
const current = document.querySelector(".current");
const old = document.querySelector(".old");
switch_current.addEventListener("click", () => {
  switch_current.classList.add("activated");
  switch_old.classList.remove("activated");
  current.classList.remove("d-none");
  old.classList.add("d-none");
});
switch_old.addEventListener("click", () => {
  switch_old.classList.add("activated");
  switch_current.classList.remove("activated");
  old.classList.remove("d-none");
  current.classList.add("d-none");
});
