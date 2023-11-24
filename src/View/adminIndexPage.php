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
            Head::css("index_admin");
            Head::scriptArray(['/fullcalendar-6.1.9/dist/index.global.min', 'calendar', 'accessibility']);
            Head::css("calendar");
            ?>
        </head>

        <body>
            <?php Utils::header('admin', false) ?>
            <main>
            <div id='calendar'></div>
            <div id="tooltip-container"></div>

            <a href="<?php echo APP_ROOT_URL_COMPLETE . "/admin/nouveau" ?>" class="button">Créer un nouveau cadavre</a>
            </main>
        </body>
        <script>
                <?php if (isset($datas['periodes'])) :?>
                var periodes_JSON = <?php echo $datas['periodes'];?>;
                <?php endif;?>
            </script>
        </html>
<?php
    }
}
