<?php

class userIndexPage
{

    public static function render(array $datas = [])
    {
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <?php
            Head::basehead();
            Head::title("Loufok | ");
            Head::scriptArray([]);
            Head::css("index_joueur");
            ?>
        </head>

        <body>
            <?php Utils::header("user"); ?>
            <main>
                <h1>Mon Espace</h1>
                <?php
                if ($datas["currentLoufokerie"])
                {
                }
                ?>
            </main>
        </body>

        </html>
<?php
    }
}
