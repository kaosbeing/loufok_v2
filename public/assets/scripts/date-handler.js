window.addEventListener("DOMContentLoaded", () => {
  const today = new Date().toISOString().split("T")[0];
  const debut = document.querySelector(".date-debut");
  const fin = document.querySelector(".date-fin");
  debut.value = today;
  fin.value = today;
  debut.min = today;
  fin.min = today;
  debut.addEventListener("change", () => {
    if (debut.value > fin.value) {
      fin.value = debut.value;
    }
  });
  fin.addEventListener("change", () => {
    if (debut.value > fin.value) {
      debut.value = fin.value;
    }
  });
});
