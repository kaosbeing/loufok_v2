<?php

session_start();
date_default_timezone_set('Europe/Paris');

require 'routes.php';

$url = parse_url($_SERVER['REQUEST_URI']);
$route = trim(str_replace(APP_ROOT_URL, '', $url['path']));

$route = $route === '' ? '/' : $route;

foreach ($routes as $r)
{
    if (in_array($route, $r['route']) && $_SERVER['REQUEST_METHOD'] === $r['method'])
    {

        // Si y'a pas de token, redirect automatiquement sur le login
        if (!$_COOKIE['token'])
        {
            HTTP::redirect('/login');
        }

        // Si la route contient le mot "admin", on vérifie les droits
        // ! Ce code empêche uniquement  les non-admin d'accéder aux routes admin, pas l'inverse
        if (in_array("admin", explode($route, "/")))
        {
            if (isset($_COOKIE['email']) && isset($_COOKIE['token']))
            {
                $user = AdministrateurModel::getInstance()->findBy(['ad_mail_administrateur' => $_COOKIE['email']])[0];

                if ($_COOKIE['token'] != $user['token'])
                {
                    ErrorController::page403();
                    exit;
                }
            }
        }

        // Récupère les paramètres spécifiés dans la route
        $params = explode('@', $r['script']);
        $controller = ucFirst($params[0]) . 'Controller';

        if (class_exists($controller, true))
        {
            $action = $params[1];

            if (method_exists($controller, $action))
            {

                // Appelle la fonction $action du contrôleur $controller
                call_user_func_array([$controller, $action], []);
                exit;
            }
        }
    }
}

ErrorController::page404($route);
