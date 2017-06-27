<?php
declare(strict_types=1);

namespace app\common;

/**
 * Класс управления доступом. Для сокращения временных затрат использует http-аутентификацию
 *
 * Class AccessControl
 * @package app\common
 */
class AccessControl {
    /**
     * http аутентификация
     */
    public static function isAuthorized(){
        if (!self::validate($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
            http_response_code(401);
            header('WWW-Authenticate: Basic realm="Test task"');
            echo "Требуется указать логин и пароль.";
            exit;
        }
    }

    /**
     * @param string $user логин
     * @param string $pass пароль
     * @return bool результат проверки
     */
    private static function validate(string $user, string $pass) : bool
    {
        $users = ['admin' => '123'];
        if (isset($users[$user]) && ($users[$user] === $pass)) {
            return true;
        } else {
            return false;
        }
    }
}
