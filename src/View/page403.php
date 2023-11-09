<?php

class Page403
{

    public static function render(array $datas = [])
    {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php
            Head::basehead();
            Head::title("Erreur 403 - Accès interdit");
            ?>
        </head>

        <body>

        </body>

        </html>
<?php
    }
}
