<?php

class Head {


    /**
     * Classe Head contenant les méthodes suivantes :
     *   - basehead()                       pour générer tous les tags par défaut
     *   - meta()                           pour générer les tags meta par défaut (charset & viewport)
     *   - favicon()                        pour importer le favicon situé dans /assets
     *   - css()                            pour importer le fichier main.css, commun à toutes les pages
     *   - script( string $script )         pour importer un script dont le nom est donné en paramètre
     *   - scripts( array $scripts )        pour importer plusieurs scripts
     *   - title( string $title )           pour générer le tag du title
     */


    /**
     * Renvoie tous les tags HTML par défaut d'un head 
     */
    public static function basehead() {
        Head::meta();
        Head::favicon();
    }


    /**
     * Renvoie les tags meta par défaut 
     */
    public static function meta() {
?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    }


    /**
     * Renvoie les tags HTML pour l'import du favicon
     */
    public static function favicon() {
    ?>
        <link rel="preload" href="<?php echo APP_ROOT_URL_COMPLETE ?>/assets/medias/images/favicon.svg" as="image" type="image/svg+xml">
        <link rel="icon" href="<?php echo APP_ROOT_URL_COMPLETE ?>/assets/medias/images/favicon.svg" type="image/svg+xml">
        <link rel="icon" href="<?php echo APP_ROOT_URL_COMPLETE ?>/assets/medias/images/favicon.png" type="image/png">
    <?php
    }

    /**
     * Importe une feuille css spécifiée
     */
    public static function css($name) {
    ?>
        <link rel="stylesheet" href="<?php echo APP_ROOT_URL_COMPLETE ?>/assets/css/<?php echo $name ?>.css">
    <?php
    }

    /**
     * Importe plusieurs feuilles css spécifiées
     */
    public static function cssArray($cssArray) {
        foreach ($cssArray as $css) {
            Head::css($css);
        }
    }

    /**
     * Renvoie un tag de script dont le nom est passé en paramètre
     */
    public static function script(string $script) {
    ?>
        <script src="<?php echo APP_ROOT_URL_COMPLETE ?>/assets/scripts/<?php echo $script ?>.js" defer></script>
    <?php
    }

    /**
     * Renvoie les tags de scripts pour chaque script du tableau
     */
    public static function scriptArray(array $scripts) {
        foreach ($scripts as $script) {
            Head::script($script);
        }
    }

    /**
     * Renvoie un tag de titre 
     */
    public static function title(string $title) {
    ?>
        <title><?php echo $title ?></title>
<?php
    }
}
?>