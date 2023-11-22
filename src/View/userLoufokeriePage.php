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
            Head::title("Loufok | {$datas['loufokerie']['titre_loufokerie']}");
            Head::css("loufokerie");
            Head::scriptArray(["draft-handler", "textarea-handler"]);
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
                        }
                    }

                    if (isset($datas['errors'])) :
                        foreach ($datas['errors'] as $error)
                        {
                        ?>
                            <span class="errors">
                                <?php
                                echo $error;
                                ?>
                            </span>
                        <?php
                        };
                    endif;

                    if (!$datas["contributed"])
                    { ?>
                        <form class="form" method="POST" enctype="multipart/form-data">
                            <div class="form__textWrapper">
                                <textarea class="input--custom-style form__textarea" name="texte" minlength="50" maxlength="280" required></textarea>
                            </div>
                            <input type='submit' class="button form__submit" value="Contribuer">
                        </form>
                    <?php }
                    ?>
                </div>
            </main>
        </body>

        </html>
<?php
    }
}
