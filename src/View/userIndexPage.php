<?php

class userIndexPage {

    public static function render(array $datas = []) {
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <?php
            Head::basehead();
            Head::title("Loufok | {$datas['user']['nom_plume']}");
            Head::css("index_joueur");
            Head::scriptArray(['switch']);
            ?>
        </head>

        <body>
            <?php Utils::header("user"); ?>
            <main>
                <h1 class="main__title">Mon Espace</h1>
                <div class="switch">
                    <div tabindex="0" class="switch-button activated" aria-selected="true" aria-label="Loufokerie active">Active</div>
                    <div tabindex="0" class="switch-button" aria-selected="false" aria-label="Dernière loufokerie">Dernière</div>
                </div>
                <div class="loufokerie current">
                    <?php
                    if ($datas["currentLoufokerie"]) {
                        $loufokerie = $datas["currentLoufokerie"];
                        $date_debut = date_format(date_create($loufokerie['date_debut_loufokerie']), 'd/m/y');
                        $date_fin = date_format(date_create($loufokerie['date_fin_loufokerie']), 'd/m/y');
                    ?>
                        <div>
                            <h4 class="loufokerie__pretitle">Loufokerie en cours</h4>
                            <h3 class="loufokerie__title"><?php echo $loufokerie["titre_loufokerie"] ?></h3>
                        </div>
                        <div class="loufokerie__infos">
                            <p class="loufokerie__dates"><?php echo $date_debut ?> - <?php echo $date_fin ?></p>
                            <p class="loufokerie__contributions"><?php echo $datas['nb_contribution'] ?> / <?php echo $loufokerie['nb_contributions'] ?><img src="<?php echo APP_ROOT_URL_COMPLETE . "/assets/medias/images/contributions.svg" ?>" alt="contributions"></p>
                        </div>
                        <hr class="loufokerie__separator">
                        <div class="loufokerie__content">
                            <?php
                            if ($datas['error']) :
                            ?>
                                <p class="loufokerie__error"><?php echo $datas['error'] ?></p>
                            <?php
                            endif;

                            if ($datas['random_contribution']) :
                            ?>
                                <p><?php echo $datas["random_contribution"]["texte"] ?></p>
                                <a href="<?php echo APP_ROOT_URL_COMPLETE . "/mon-espace/loufokerie" ?>" class="loufokerie__joinContrib">Voir la loufokerie</a>
                            <?php
                            else :
                            ?>
                                <p>Vous n'avez pas encore de contribution attribuée</p>
                                <a href="<?php echo APP_ROOT_URL_COMPLETE . "/mon-espace/loufokerie" ?>" class="loufokerie__joinContrib">Rejoindre la loufokerie</a>
                            <?php
                            endif;
                            ?>
                        </div>
                    <?php
                    } else { ?>
                        <p>Aucune loufokerie en cours</p>
                    <?php } ?>
                </div>
                <div class="loufokerie old d-none">
                    <?php
                    if ($datas["oldLoufokerie"]) {
                        $loufokerie = $datas["oldLoufokerie"];
                        $date_debut = date_format(date_create($loufokerie['date_debut_loufokerie']), 'd/m/y');
                        $date_fin = date_format(date_create($loufokerie['date_fin_loufokerie']), 'd/m/y');
                    ?>
                        <div>
                            <h4 class="loufokerie__pretitle">Ancienne Loufokerie</h4>
                            <h3 class="loufokerie__title"><?php echo $loufokerie["titre_loufokerie"] ?></h3>
                        </div>
                        <div class="loufokerie__infos">
                            <p class="loufokerie__dates"><?php echo $date_debut ?> - <?php echo $date_fin ?></p>
                            <p class="loufokerie__contributions"><?php echo $datas['nb_old_contributions'] ?> <img src="<?php echo APP_ROOT_URL_COMPLETE . "/assets/medias/images/contributions.svg" ?>" alt="contributions"></p>
                        </div>
                        <hr class="loufokerie__separator">
                        <div class="loufokerie__content">
                            <?php
                            if ($datas['error']) :
                            ?>
                                <p class="loufokerie__error"><?php echo $datas['error'] ?></p>
                            <?php
                            endif; ?>
                            <p><?php echo $datas['old_contribution']['texte'] ?></p>
                            <a href="<?php echo APP_ROOT_URL_COMPLETE . "/mon-espace/historique" ?>" class="loufokerie__joinContrib">Voir la dernière Loufokerie</a>
                        </div>
                    <?php
                    } else { ?>
                        <p>Vous n'avez participé à aucune autre loufokerie</p>
                    <?php } ?>
                </div>
            </main>
        </body>

        </html>
<?php
    }
}
