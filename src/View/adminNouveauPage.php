<?php

class adminNouveauPage
{

    public static function render(array $datas = [])
    {
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <?php
            Head::basehead();
            Head::title("Loufok | Administrateur");
            Head::scriptArray(["date-handler", "textarea-handler"]);
            Head::cssArray(["admin"]);
            ?>
        </head>

        <body>
            <?php Utils::header('admin', true) ?>
            <main>
                <form class="form" action="" method="POST" enctype="multipart/form-data">
                    <div class="form__element">
                        <label for="titre">Titre</label>
                        <input class='input--custom-style' type="text" name="titre" required>
                    </div>
                    <div class="form__element">
                            <label for="date-debut">Début</label>
                            <input class='date-debut input--custom-style' type="date" name="date-debut" required>
                            <label for="date-fin">Fin</label>
                            <input class='date-fin input--custom-style' type="date" name="date-fin" required>
                    </div>
                        
                    <div class="form__element">
                            <label for="nb_contributions">Nombre de contributions</label>
                            <input class='input--custom-style' type="number" min='2' name="nb_contributions" required>
                    </div>
                    <div class="form__element">
                            <label for="texte">Première contribution</label>
                            <textarea class='input--custom-style contribution__input' name="texte" required maxlength="280" minlength="50"></textarea>
                    </div>
                    <input type='submit' class="button" value="Créer">
                </form>
            </main>
        </body>
        </html>
<?php
    }
}
