const submission_area = document.querySelector('.form__textarea');
let savetimer = setTimeout(() => { }, 0);
if (submission_area != null) {

    let local_draft = localStorage.getItem("submission_draft");

    if (local_draft != null) {
        submission_area.value = local_draft;
    }

    /* Idea is : The draft is saved few seconds after the user stops typing */
    submission_area.addEventListener('input', () => {
        clearTimeout(savetimer);

        savetimer = setTimeout(() => {
            saveDraft();
        }, 3000);
    })
}

function saveDraft() {
    localStorage.setItem("submission_draft", submission_area.value);

}