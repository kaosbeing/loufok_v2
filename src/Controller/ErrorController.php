<?php

class ErrorController
{
    public static function page404($route)
    {
        $user_type = Utils::userType($_COOKIE['token']);
        Page404::render(["route" => $route, "user_type" => $user_type]);
    }

    public static function page403()
    {
        Page403::render();
    }
}
