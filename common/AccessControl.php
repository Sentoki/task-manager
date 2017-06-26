<?php
declare(strict_types=1);

namespace app\common;

class AccessControl {
    public static function isAuthorized(){
        if (!self::validate($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
            http_response_code(401);
            header('WWW-Authenticate: Basic realm="Test task"');
            echo "Требуется указать логин и пароль.";
            exit;
        }
    }

    private static function validate($user, $pass) {
        $users = ['admin' => '123'];
        if (isset($users[$user]) && ($users[$user] === $pass)) {
            return true;
        } else {
            return false;
        }
    }
}
