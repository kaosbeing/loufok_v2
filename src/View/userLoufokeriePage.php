<?php

class userLoufokeriePage
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
            Head::css("loufokerie");
            ?>
        </head>

        <body>
            <?php Utils::header("user", true); ?>
            <main>
                <h1 class="main__title"><?php echo $datas["loufokerie"]["titre_loufokerie"] ?></h1>
                <div class="contributions">
                    <?php
                    foreach ($datas["contributionArray"] as $contribution)
                    {
                    ?>
                        <?php
                        if ($contribution != "")
                        {
                        ?>
                            <div class="contribution">
                                <p><?php echo $contribution ?></p>
                            </div>
                        <?php
                        }
                        else
                        {
                        ?>
                            <div class="contribution contribution--unknown">
                                <img class="contribution__questionmark" src="<?php echo APP_ROOT_URL_COMPLETE . "/assets/medias/images/question_mark.svg" ?>" alt="question mark">
                                <img class="contribution__questionmark" src="<?php echo APP_ROOT_URL_COMPLETE . "/assets/medias/images/question_mark.svg" ?>" alt="question mark">
                                <img class="contribution__questionmark" src="<?php echo APP_ROOT_URL_COMPLETE . "/assets/medias/images/question_mark.svg" ?>" alt="question mark">
                            </div>
                        <?php
                        } if (!$datas["contributed"]){?>
                        <form action="" class="form"  method="POST" enctype="multipart/form-data">
                            <textarea class="input--custom-style" name="texte" minlength="50" maxlength="280" required></textarea>
                            <input type='submit' class="button" value="Contribuer">
                        </form>
                    <?php }
                    }
                    ?>
                </div>
                <?php if (isset($datas['errors'])) :
                    ?>
                        <span class="errors"><?php echo $datas['errors'][0]; ?></span>
                    <?php
                    endif;
                    ?>
            </main>
        </body>

        </html>
<?php
    }
}
