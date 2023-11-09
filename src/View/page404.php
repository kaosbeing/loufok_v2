<?php

class Page404
{

    public static function render(array $datas = [])
    {
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <?php
            Head::basehead();
            Head::css("page404");
            Head::title("Erreur 404 - Aucune page trouvée");
            ?>
        </head>

        <body>
            <?php Utils::header($datas['user_type']); ?>
            <main class="err">
                <h1 class="err__title">404</h1>
                <p class="err__message">La page <span class="err__route"><?php echo $datas["route"] ?></span> n'existe pas ou n'a pas pu être trouvée</p>
            </main>
        </body>

        </html>
<?php
    }
}
