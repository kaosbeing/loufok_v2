<?php

class LoginPage
{

    public static function render(array $datas = [])
    {
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <?php
            Head::basehead();
            Head::css("main");
            Head::title("Connexion");
            ?>
        </head>

        <body>
            <p>Bon eh bah....</p>
        </body>

        </html>
<?php
    }
}
