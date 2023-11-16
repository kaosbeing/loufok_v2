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
            Head::title("Loufok | {$datas['user']['nom_plume']}");
            Head::scriptArray([]);
            Head::css("index_joueur");
            ?>
        </head>

        <body>
            <?php Utils::header("user"); ?>
            <main>
                <h1 class="main__title">Mon Espace</h1>
                <?php
                if ($datas["currentLoufokerie"])
                {
                    $loufokerie = $datas["currentLoufokerie"];
                    $date_debut = date_format(date_create($loufokerie['date_debut_loufokerie']), 'd M Y');
                    $date_fin = date_format(date_create($loufokerie['date_fin_loufokerie']), 'd M Y');
                ?>
                    <div class="loufokerie">
                        <h3 class="loufokerie__title"><?php echo $loufokerie["titre_loufokerie"] ?></h3>
                        <div class="loufokerie__infos">
                            <p class="loufokerie__dates"><?php echo $date_debut ?> - <?php echo $date_fin ?></p>
                            <p class="loufokerie__contributions"><?php echo $datas['nb_contribution'] ?> / <?php echo $loufokerie['nb_contributions'] ?><img src="<?php echo APP_ROOT_URL_COMPLETE . "/assets/medias/images/contributions.svg" ?>" alt="contributions"></p>
                        </div>
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
                    </div>
                <?php
                }
                if ($datas["oldLoufokerie"])
                {
                    $loufokerie = $datas["oldLoufokerie"];
                    $date_debut = date_format(date_create($loufokerie['date_debut_loufokerie']), 'd M Y');
                    $date_fin = date_format(date_create($loufokerie['date_fin_loufokerie']), 'd M Y');
                ?>
                    <div class="loufokerie">
                        <h3 class="loufokerie__title"><?php echo $loufokerie["titre_loufokerie"] ?></h3>
                        <div class="loufokerie__infos">
                            <p class="loufokerie__dates"><?php echo $date_debut ?> - <?php echo $date_fin ?></p>
                            <p class="loufokerie__contributions"><?php echo $datas['nb_contribution'] ?> <img src="<?php echo APP_ROOT_URL_COMPLETE . "/assets/medias/images/contributions.svg" ?>" alt="contributions"></p>
                        </div>
                        <div class="loufokerie__content">
                            <?php
                            if ($datas['error']) :
                            ?>
                                <p class="loufokerie__error"><?php echo $datas['error'] ?></p>
                            <?php
                            endif;?>
                                <p><?php echo $datas['old_contribution']['texte'] ?></p>
                                <a href="<?php echo APP_ROOT_URL_COMPLETE . "/mon-espace/historique" ?>" class="loufokerie__joinContrib">Voir la dernière Loufokerie</a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </main>
        </body>

        </html>
<?php
    }
}
