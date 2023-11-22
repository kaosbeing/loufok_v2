<?php

session_start();
date_default_timezone_set('Europe/Paris');

require 'routes.php';

$url = parse_url($_SERVER['REQUEST_URI']);
$route = trim(str_replace(APP_ROOT_URL, '', $url['path']));

$route = $route === '' ? '/' : $route;

$route_types = ["float" => '(\d+[.]?\d*)', "string" => '(\S+)', "bool" => '(\d{1})', "int" => '(\d+)'];

foreach ($routes as $r['route']) {
}


foreach ($routes as $r) {
    if ($_SERVER['REQUEST_METHOD'] === $r['method']) {

        // Si y'a pas de token, redirect automatiquement sur le login
        if (!isset($_COOKIE['token']) && ($route != "/" && $route != "/login")) {
            HTTP::redirect("/login");
            exit;
        } else if (isset($_COOKIE['token']) && ($route == "/" || $route == "/login")) {


            $usertype = Utils::userType($_COOKIE['token']);
            if ($usertype == "admin") {
                HTTP::redirect("/admin");
                exit;
            } else if ($usertype == "user") {
                HTTP::redirect("/mon-espace");
                exit;
            }
        }

        // Si la route contient le mot "admin", on vérifie les droits
        // ! Ce code empêche uniquement  les non-admin d'accéder aux routes admin, pas l'inverse
        if (in_array("admin", explode($route, "/"))) {
            if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
                $user = AdministrateurModel::getInstance()->findBy(['ad_mail_administrateur' => $_COOKIE['email']])[0];

                if ($_COOKIE['token'] != $user['token']) {
                    ErrorController::page403($route);
                    exit;
                }
            }
        }

        // Si la route contient le mot "mon-espace", on vérifie les droits
        // ! Ce code empêche les non-connectés d'accéder aux routes privées
        if (in_array("mon-espace", explode($route, "/"))) {
            if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
                $user = JoueurModel::getInstance()->findBy(['ad_mail_joueur' => $_COOKIE['email']])[0];

                if ($_COOKIE['token'] != $user['token']) {
                    ErrorController::page403($route);
                    exit;
                }
            }
        }

        foreach ($r['route'] as $routeURL) {
            preg_match_all('/{\S*:?([^:]+)}/U', $routeURL, $func_args);
            $psroute = preg_replace_callback('/{(\S*)?:?[^:]+}/U', function ($matches) {
                return isset($matches[1]) ? $route_types[$matches[1]] ?? '([^/]+)' : '([^/]+)';
            }, $routeURL);


            if (preg_match('#^/?' . $psroute . '/*$#', $route, $arguments)) {


                array_shift($arguments);
                $args = array_combine($func_args[1], $arguments);

                // Récupère les paramètres spécifiés dans la route
                $params = explode('@', $r['script']);
                $controller = ucFirst($params[0]) . 'Controller';

                if (class_exists($controller, true)) {
                    $action = $params[1];

                    if (method_exists($controller, $action)) {

                        // Appelle la fonction $action du contrôleur $controller
                        call_user_func_array([$controller, $action], $args);
                        exit;
                    }
                }
            }
        }
    }
}


function regexArrayMatch($regexArray, $string) {
    $result = false;
    foreach ($regexArray as $regex) {
        if (preg_match($regex, $string)) {
            var_dump($regex);
            var_dump($string);
            $result = true;
        }
    }
    return $result;
}
ErrorController::page404($route);
