<?php

session_start();

require 'routes.php';

$url = parse_url($_SERVER['REQUEST_URI']);
$route = trim(str_replace(APP_ROOT_URL, '', $url['path']));

$route = $route === '' ? '/' : $route;

foreach ($routes as $r) {
    if (in_array($route, $r['route']) && $_SERVER['REQUEST_METHOD'] === $r['method']) {
        $params = explode('@', $r['script']);
        $controller = ucFirst($params[0]) . 'Controller';

        if (class_exists($controller, true)) {
            $action = $params[1];

            if (method_exists($controller, $action)) {
                call_user_func_array([$controller, $action], []);
            }
        }
    }
}
