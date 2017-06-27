<?php
declare(strict_types=1);

namespace app\controllers;

use app\common\Router;
use app\exceptions\Exception404;

/**
 * Общая логика работы контроллеров
 *
 * Class Controller
 * @package app\controllers
 */
abstract class Controller {
    /**
     * Экземпляр синглетона
     *
     * @var Controller
     */
    private static $instance;

    /**
     * @var Router null
     */
    private $router = null;

    /**
     * Синглетон, приватный конструктор
     * Controller constructor.
     */
    private function __construct()
    {
    }

    /**
     * Получение экземляра синглетона и проверка контроллера и экшена
     *
     * @param Router $router
     * @return Controller
     * @throws Exception404
     */
    public static function getInstance(Router $router) : Controller
    {
        $controllerName = 'app\\controllers\\' . $router->getController();
        if (!class_exists($controllerName)) {
            throw new Exception404();
        }
        /** @var Controller $controller */
        $controller = new $controllerName;
        $controller->setRouter($router);

        $actionName = 'action' . $router->getAction();
        if (!method_exists($controller, $actionName)) {
            throw new Exception404();
        }
        if (!isset(static::$instance)) {
            static::$instance = $controller;
        }

        return static::$instance;
    }

    /**
     * Сеттер роутера
     *
     * @param Router $router
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Геттер роутера
     *
     * @return Router
     */
    public function getRouter() : Router
    {
        return $this->router;
    }

    /**
     * Метод обёртка для вызова экшена контроллера
     * @return string
     */
    public function doAction() : string
    {
        $action = 'action' . $this->router->getAction();
        return $this->$action();
    }

    /**
     * Проверка существования представления
     *
     * @param string $template название представления
     * @return bool
     * @throws \Exception
     */
    private function isTemplateExists(string $template) : bool
    {
        if (!file_exists(__DIR__ . '/../views/' . $template . '.php')) {
            throw new \Exception("Template {$template} don't exist");
        }
        return true;
    }

    /**
     * Отображение страницы
     *
     * @param string $template название представления
     * @param array $params параметры передаваемые в представление
     * @return string контент выводимый в браузер
     */
    public function render(string $template, array $params = []) : string
    {
        $this->isTemplateExists($template);
        foreach ($params as $key => $param) {
            $$key = $param;
        }
        ob_start();
        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/' . $template . '.php';
        require_once __DIR__ . '/../views/footer.php';
        $content = ob_get_clean();
        return $content;
    }

    /**
     * Перенаправление пользователя
     *
     * @param string $url
     */
    public function redirect(string $url)
    {
        $url = 'http://'. $_SERVER['SERVER_NAME'] . $url;
        header("Location: {$url}");
        exit;
    }
}
