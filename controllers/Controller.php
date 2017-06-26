<?php
declare(strict_types=1);

namespace app\controllers;

use app\common\Router;
use app\exceptions\Exception404;

abstract class Controller {
    private static $instance;
    /**
     * @var Router null
     */
    private $router = null;

    private function __construct()
    {
    }

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

    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    public function getRouter()
    {

    }

    public function doAction() : string
    {
        $action = 'action' . $this->router->getAction();
        return $this->$action();
    }

    private function isTemplateExists(string $template) : bool
    {
        if (!file_exists(__DIR__ . '/../views/' . $template . '.php')) {
            throw new \Exception("Template {$template} don't exist");
        }
        return true;
    }

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

    public function redirect(string $url)
    {
        $url = 'http://'. $_SERVER['SERVER_NAME'] . $url;
        header("Location: {$url}");
        exit;

    }
}
