<?php
declare(strict_types=1);

namespace app\common;

class Router {
    private $controller;
    private $action;

    public function parseUri()
    {
        if (in_array($_SERVER['REQUEST_URI'], ['/', '/index.php'])) {
            $this->controller = 'site';
            $this->action = 'index';
        } else {
            if (isset($_GET['controller'])) {
                $this->controller = $_GET['controller'];
            }
            if (isset($_GET['action'])) {
                $this->action = $_GET['action'];
            }
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public static function getUrl(string $controller, string $action, array $params = []): string
    {
        $url = "/web/index.php?controller={$controller}&action={$action}";
        foreach ($params as $key => $value) {
            $url .= "&{$key}={$value}";
        }
        return $url;
    }
}
