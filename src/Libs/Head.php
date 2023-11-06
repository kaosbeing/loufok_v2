<?php

class Head
{
    public static function fullhead()
    {
        Head::meta();
        Head::favicon();
        Head::css();
    }


    public static function meta()
    {
?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    }


    /**
     * Renvoie les tags HTML pour l'import du favicon
     */
    public static function favicon()
    {
    ?>
        <link rel="preload" href="<?php APP_ROOT_URL_COMPLETE ?>/public/assets/favicon.svg" as="image" type="image/svg+xml">
        <link rel="icon" href="<?php APP_ROOT_URL_COMPLETE ?>/public/assets/favicon.svg" type="image/svg+xml">
        <link rel="icon" href="<?php APP_ROOT_URL_COMPLETE ?>/public/assets/favicon.png" type="image/png">
    <?php
    }

    /**
     * Renvoie les tags HTML lié au css
     */
    public static function css()
    {
    ?>
        <link rel="stylesheet" href="<?php APP_ROOT_URL_COMPLETE ?>/public/css/main.css">
    <?php
    }

    /**
     * Renvoie un tag de script dont le nom est passé en paramètre
     */
    public static function script(string $script)
    {
    ?>
        <script src="<?php APP_ROOT_URL_COMPLETE ?>/public/js/<?php $script ?>.js" defer></script>
<?php
    }

    /**
     * Renvoie les tags de scripts pour chaque script du tableau
     */
    public static function scripts(array $scripts)
    {
        foreach ($scripts as $script) {
            Head::script($script);
        }
    }
}
?>