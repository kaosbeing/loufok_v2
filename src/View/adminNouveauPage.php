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
            Head::title("Loufok | Nouvelle Loufokerie");
            Head::css("nouveau");
            Head::scriptArray(["date-handler", "textarea-handler", "admin", '/fullcalendar-6.1.9/dist/index.global.min', 'calendar',  'accessibility']);
            Head::css("calendar");
           
            ?>
        </head>

        <body>
            <?php Utils::header('admin', true);?>
            <main>
                <div id='calendar'></div>
                <div id="tooltip-container"></div>

                <form class="form form--new" action="" method="POST" enctype="multipart/form-data">
                    <div class="form__element">
                        <label for="titre">Titre</label>
                        <input class='input--custom-style titre' type="text" name="titre" required>
                    </div>
                    <div class="form__element">
                            <label for="date-debut">Début</label>
                            <input class='date-debut input--custom-style' type="date" name="date-debut" required>
                            <label for="date-fin">Fin</label>
                            <input class='date-fin input--custom-style' type="date" name="date-fin" required>
                    </div>
                    <div class="form__element">
                            <label for="nb_contributions">Nombre de contributions</label>
                            <input class='input--custom-style nb-contrib' type="number" min='2' name="nb_contributions" required>
                    </div>
                    <div class="form__element">
                        <label for="texte">Première contribution</label>
                        <div class="form__textWrapper">
                            <textarea class="input--custom-style form__textarea" name="texte" minlength="50" maxlength="280" required></textarea>
                        </div>
                    </div>
                    <input type='submit' class="button" value="Créer">
                </form>
                <span class="errors"><?php if (isset($datas['errors'])) : foreach ($datas['errors'] as $error) {echo $error;} endif;?></span>
             
            </main>
            <?php Utils::footer(); ?>
        </body>
            <script>
                <?php if (isset($datas['titres'])) :?>
                var titres_JSON = <?php echo $datas['titres'];?>;
                <?php endif;?>
                <?php if (isset($datas['periodes'])) :?>
                var periodes_JSON = <?php echo $datas['periodes'];?>;
                <?php endif;?>
            </script>
        </html>
<?php
    }
}
