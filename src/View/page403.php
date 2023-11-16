<?php

class Page403 {

    public static function render(array $datas = []) {
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <?php
            Head::basehead();
            Head::css("errorPage");
            Head::title("Erreur 403 - Aucune authorisation trouvée");
            ?>
        </head>

        <body>
            <?php Utils::header($datas['user_type']); ?>
            <main class="err">
                <h1 class="err__title">403</h1>
                <p class="err__message">Vous n'avez pas accès à la page <span class="err__route"><?php echo $datas["route"] ?></span></p>
            </main>
        </body>

        </html>
<?php
    }
}
