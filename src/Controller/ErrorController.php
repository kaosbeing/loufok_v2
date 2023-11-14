<?php

class ErrorController {
    /* Returns the view for page 404 */
    public static function page404($route) {
        if (isset($_COOKIE['token'])) {
            $user_type = Utils::userType($_COOKIE['token']);
        } else {
            $user_type = "";
        }
        Page404::render(["route" => $route, "user_type" => $user_type]);
    }

    /* Returns the view for page 403 */
    public static function page403() {
        Page403::render();
    }
}
