<?php

session_start();

require 'routes.php';

$url = parse_url($_SERVER['REQUEST_URI']);
$route = trim(str_replace(APP_ROOT_URL, '', $url['path']));

$route = $route === '' ? '/' : $route;

foreach ($routes as $r) {
    if (in_array($route, $r['route']) && in_array($_SERVER['REQUEST_METHOD'], $r['method'])) {
        if (str_contains($route, '/admin')) {
            if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
                $user = Administrateur::getInstance()->findBy(['ad_mail_administrateur' => $_COOKIE['email']])[0];
                if ($_COOKIE['token'] == $user['token']) {
                    require 'View/'.$r['script'];
                    exit;
                }
            }
            require 'View/403.php';
            exit;
        }
        if (str_contains($route, '/mon-espace')) {
            if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
                $user = Joueur::getInstance()->findBy(['ad_mail_joueur' => $_COOKIE['email']])[0];
                if ($_COOKIE['token'] == $user['token']) {
                    require 'View/'.$r['script'];
                    exit;
                }
            }
            require 'View/403.php';
            exit;
        }
        require 'View/'.$r['script'];
        exit;
    }
}
require 'View/404.php';
