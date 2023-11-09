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
            Head::scriptArray([]);
            Head::cssArray(["admin"]);
            ?>
        </head>

        <body>
            
        </body>

        </html>
<?php
    }
}
