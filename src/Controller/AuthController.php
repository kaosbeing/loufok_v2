<?php

class AuthController
{
    public static function logIn()
    {
        $token_gen = uniqid();
        $admin = AdministrateurModel::getInstance()->findBy(['ad_mail_administrateur' => $_POST['email']]);
        $joueur = JoueurModel::getInstance()->findBy(['ad_mail_joueur' => $_POST['email']]);
        if ($admin) {
            $user = $admin[0];
            if ($_POST['password'] == $user['mot_de_passe_administrateur']) {
                setcookie('email', $user['ad_mail_administrateur'], time() + (10 * 365 * 24 * 60 * 60));
                setcookie('token', $token_gen, time() + time() + (10 * 365 * 24 * 60 * 60));
                AdministrateurModel::getInstance()->update($user['id'], [
                    'token' => $token_gen,
                ]);
                HTTP::redirect('/admin');
            }
        } else {
            LoginPage::render(['errors' => 'Identifiants invalides']);
        }
        if ($joueur) {
            $user = $joueur[0];
            if ($_POST['password'] == $user['mot_de_passe_joueur']) {
                setcookie('email', $user['ad_mail_administrateur'], time() + (10 * 365 * 24 * 60 * 60));
                setcookie('token', $token_gen, time() + time() + (10 * 365 * 24 * 60 * 60));
                JoueurModel::getInstance()->update($user['id'], [
                    'token' => $token_gen,
                ]);
                HTTP::redirect('/mon-espace');
            }
        } else {
            LoginPage::render(['errors' => 'Identifiants invalides']);
        }
    }

    public static function loginPage()
    {
        LoginPage::render();
    }
}
