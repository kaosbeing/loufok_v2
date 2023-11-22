<?php

class userHistoriquePage
{

    public static function render(array $datas = [])
    {
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <?php
            Head::basehead();
            Head::title("Loufok | {$datas['loufokerie']['titre_loufokerie']}");
            Head::css("historique");
            Head::scriptArray([]);
            ?>
        </head>

        <body>
        <?php Utils::header("user", true); ?>
            <main>
                <h1 class="main__title"><?php echo $datas["loufokerie"]["titre_loufokerie"] ?></h1>
                <div class="info"><span>Durée : <?php echo $datas["duree"] ?> jours </span><span> Contributions :  <?php echo count($datas["contributions"]) - 1; ?></span> </div n>
                <div class="contributions">
                    <?php
                    foreach ($datas["contributions"] as $contribution)
                    {
                    ?>
                    <div class="contribution">
                        <p><?php echo $contribution['texte'] ?></p>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="joueurs">
                    <h4>Participants : </h4>
                    <div class="joueurs-noms">
                        <?php echo $datas["joueurs"][0]['nom_plume']; $one = false; ?>
                        <?php foreach ($datas["joueurs"] as $joueur) {
                            if ($one) {
                                echo ' - '.$joueur['nom_plume'];
                            } else {
                                $one = true;
                            }
                        }?>
                    </div>
                </div>
            </main>
        </body>
        </html>
<?php
    }
}
