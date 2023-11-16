<?php

class adminIndexPage
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
            Head::scriptArray([]);
            Head::cssArray(["index_admin"]);
            ?>
        </head>

        <body>
            <?php Utils::header('admin', false) ?>
            <main>
                <a href="/admin/nouveau" class="button">Créer un nouveau cadavre</a>
            </main>
        </body>

        </html>
<?php
    }
}
