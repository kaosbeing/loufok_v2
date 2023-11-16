<?php

class LoginPage {

    public static function render(array $datas = []) {
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <?php
            Head::basehead();
            Head::title("Loufok | Connexion");
            Head::scriptArray(["checkbox-eye"]);
            Head::cssArray(["login"]);
            ?>
        </head>

        <body>
            <form action="" method="POST" class="form"> <!-- To verify -->
                <img src="<?php APP_ROOT_URL_COMPLETE ?>/assets/medias/images/logotype.svg" alt="">
                <div class="form__element">
                    <label for="email">Email</label>
                    <input class='input--custom-style' type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="form__element">
                    <label for="password">Mot de passe</label>
                    <div class="password__wrapper input--custom-style">
                        <input class="password" type="password" name="password" id="password" placeholder="Mot de passe" required>
                        <label class="form__checkbox">
                            <input class="form__toggle" type="checkbox" id="toggle-password">
                            <svg class="eye eye--hide" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.2356 1.99299C21.0408 1.99866 20.8559 2.07992 20.72 2.21955L2.21995 20.7195C2.14797 20.7887 2.09051 20.8714 2.05092 20.963C2.01133 21.0546 1.99042 21.1532 1.98941 21.253C1.98839 21.3528 2.0073 21.4517 2.04501 21.5441C2.08273 21.6365 2.1385 21.7204 2.20906 21.791C2.27962 21.8615 2.36354 21.9173 2.45593 21.955C2.54831 21.9928 2.64729 22.0117 2.74707 22.0106C2.84685 22.0096 2.94542 21.9887 3.03702 21.9491C3.12861 21.9095 3.21139 21.8521 3.2805 21.7801L8.45823 16.6024C9.34258 17.5594 10.6004 18.1649 12.0002 18.1649C14.6652 18.1649 16.8352 15.9948 16.8352 13.3348C16.8352 11.9349 16.2298 10.6734 15.2727 9.78791L17.5266 7.534C19.9525 8.95438 21.8346 11.2482 22.5256 13.9344C22.6106 14.2744 22.9152 14.4998 23.2502 14.4998C23.3102 14.4998 23.3748 14.4944 23.4348 14.4744C23.8398 14.3744 24.0798 13.9653 23.9748 13.5653C23.2049 10.5639 21.2308 8.03637 18.6389 6.4217L21.7805 3.2801C21.8887 3.17472 21.9626 3.03913 21.9924 2.89108C22.0223 2.74303 22.0068 2.5894 21.9479 2.45032C21.889 2.31124 21.7895 2.19317 21.6624 2.11157C21.5353 2.02997 21.3866 1.98864 21.2356 1.99299V1.99299ZM11.9953 4.49982C6.41034 4.49982 1.37562 8.31025 0.0256167 13.5653C-0.0793833 13.9653 0.160656 14.3744 0.565656 14.4744C0.965656 14.5794 1.37484 14.3394 1.47484 13.9344C2.63984 9.40939 7.16534 5.99982 11.9953 5.99982C12.8503 5.99982 13.695 6.10439 14.51 6.30939L15.7405 5.0799C14.5455 4.6999 13.2853 4.49982 11.9953 4.49982ZM12.0002 8.49982C9.33523 8.49982 7.17015 10.6698 7.17015 13.3348C7.17015 13.4348 7.17491 13.5395 7.17991 13.6395L12.3098 8.50959C12.2048 8.50459 12.1052 8.49982 12.0002 8.49982Z" />
                            </svg>
                            <svg class="eye eye--visible" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12,4.5c-5.7,0-10.6,3.9-12,9.1c0,0.2,0,0.4,0.1,0.6c0.1,0.2,0.3,0.3,0.5,0.3c0.2,0,0.4,0,0.6-0.1
                                    c0.2-0.1,0.3-0.3,0.3-0.5C2.6,9.5,7,6,12,6c5,0,9.4,3.5,10.5,7.9c0,0.2,0.2,0.4,0.3,0.5c0.2,0.1,0.4,0.1,0.6,0.1
                                    c0.2,0,0.4-0.2,0.5-0.3C24,14,24,13.8,24,13.6C22.7,8.4,17.7,4.5,12,4.5z M12,8.5c-2.7,0-4.8,2.2-4.8,4.8c0,2.7,2.2,4.8,4.8,4.8
                                    c2.7,0,4.8-2.2,4.8-4.8C16.8,10.7,14.7,8.5,12,8.5z" />
                            </svg>
                        </label>
                    </div>
                    <?php if (isset($datas['error'])) :
                    ?>
                        <span class="errors"><?php echo $datas['error']; ?></span>
                    <?php
                    endif;
                    ?>
                </div>
                <input class="button" type="submit" value="Se connecter">
            </form>

        </body>

        </html>
<?php
    }
}
