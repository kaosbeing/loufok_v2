window.addEventListener('DOMContentLoaded', () => {
    const submission_area = document.querySelector('.form__textarea');
    let savetimer = setTimeout(() => { }, 0);
    if (submission_area != null) {
        let local_draft = localStorage.getItem(user_token);

        if (local_draft != null) {
            submission_area.value = local_draft;
        }

        /* Idea is : The draft is saved few seconds after the user stops typing */
        submission_area.addEventListener('input', () => {
            clearTimeout(savetimer);

            savetimer = setTimeout(() => {
                saveDraft();
            }, 2000);
        })
    }

    function saveDraft() {
        localStorage.setItem(user_token, submission_area.value);

        var pos = submission_area.getBoundingClientRect();
        let popup = document.createElement('span');

        popup.style.backgroundColor = "#eee";
        popup.style.borderRadius = "4px";
        popup.style.position = "absolute";
        popup.style.padding = "0.5rem";
        popup.innerHTML = "Brouillon Enregistré !"
        document.body.append(popup);
        popup.style.top = pos.top + window.scrollY - popup.offsetHeight - 8 + "px"; // Put popup on top of element
        popup.style.left = pos.left + submission_area.offsetWidth / 2 - popup.offsetWidth / 2 + "px"; // Put center of popup on center of the element

        popupTimeout = setTimeout(() => {
            popup.remove();
        }, 1000);
    }
})