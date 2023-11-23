window.addEventListener("DOMContentLoaded", () => {
  const today = new Date().toISOString().split("T")[0];
  const form = document.querySelector(".form--new");
  const titre = document.querySelector(".titre");
  const debut = document.querySelector(".date-debut");
  const fin = document.querySelector(".date-fin");
  const nb_contrib = document.querySelector(".nb-contrib");
  const contrib = document.querySelector(".form__textarea");
  const errors_span = document.querySelector(".errors");
  let local_form = localStorage.getItem("form_admin");
  if (local_form != null) {
    titre.value = local_form["titre"];
    debut.value = local_form["debut"];
    fin.value = local_form["fin"];
    nb_contrib.value = local_form["nb_contrib"];
    contrib.value = local_form["contrib"];
  }
  form.addEventListener("submit", (e) => {
    let errors = [];
    titres_JSON.forEach((titre_val) => {
      if (titre_val.titre_loufokerie == titre) {
        errors.push("Le titre " + titre + " est déjà utilisé.");
      }
    });
    if (debut.value < today || fin.value < today || fin.value > debut.value) {
      errors.push("La date est invalide");
    }
    periodes_JSON.forEach((periodes) => {
      if (
        (debut.value >= periodes.date_debut_loufokerie &&
          debut.value <= periodes.date_fin_loufokerie) ||
        (fin.value >= periodes.date_debut_loufokerie &&
          fin.value <= periodes.date_fin_loufokerie)
      ) {
        errors.push("Une autre loufokerie est déjà prévue a cette période.");
      }
    });
    if (nb_contrib.value < 1) {
      errors.push("Le nombre de contributions est inférieur au minimum.");
    }
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
      let local = {
        titre: titre.value,
        debut: debut.value,
        fin: fin.value,
        nb_contrib: nb_contrib.value,
        contrib: contrib.value,
      };
      localStorage.setItem("form_admin", local);
      e.preventDefault();
    } else {
      localStorage.removeItem("form_admin");
    }
  });
});
