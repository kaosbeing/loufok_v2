<?php

class AuthController {
    public static function logIn() {
        $token_gen = uniqid();
        $error = null;

        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $error = "Tous les champs n'ont pas été remplis";
        }

        $joueur = JoueurModel::getInstance()->findBy(['ad_mail_joueur' => $_POST['email']]);
        $admin = AdministrateurModel::getInstance()->findBy(['ad_mail_administrateur' => $_POST['email']]);

        if (!$joueur && !$admin) {
            $error = "Identifiants invalides";
        }

        if ($joueur) {
            $user = $joueur[0];
            if ($_POST['password'] == $user['mot_de_passe_joueur']) {
                setcookie('email', $user['ad_mail_joueur'], time() + (10 * 365 * 24 * 60 * 60));
                setcookie('token', $token_gen, time() + time() + (10 * 365 * 24 * 60 * 60));
                JoueurModel::getInstance()->update($user['id'], [
                    'token' => $token_gen,
                ]);
                HTTP::redirect('/mon-espace');
            } else {
                $error = "Identifiants invalides";
            }
        }

        if ($admin) {
            $user = $admin[0];
            if ($_POST['password'] == $user['mot_de_passe_administrateur']) {
                setcookie('email', $user['ad_mail_administrateur'], time() + (10 * 365 * 24 * 60 * 60));
                setcookie('token', $token_gen, time() + time() + (10 * 365 * 24 * 60 * 60));
                AdministrateurModel::getInstance()->update($user['id'], [
                    'token' => $token_gen,
                ]);
                HTTP::redirect('/admin');
            } else {
                $error = "Identifiants invalides";
            }
        }

        if ($error) {
            AuthController::loginPage($error);
        }
    }

    public static function logOut() {
        /* Delete cookies */
        setcookie('email', "", time() - 1);
        setcookie('token', "", time() - 1);
        HTTP::redirect();
    }

    public static function loginPage(string $error = null) {
        LoginPage::render(['error' => $error]);
    }
}
