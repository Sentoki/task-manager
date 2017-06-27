<?php
declare(strict_types=1);

use app\common\Router;
use app\controllers\Controller;
use app\exceptions\Exception404;

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    echo "<h1>Error detected!</h1>";
    echo "<h2>{$errstr}, code {$errno}</h2>";
    echo "File: {$errfile}, line{$errline}<br>";
});

set_exception_handler(function (Throwable $exception) {
    if ($exception instanceof Exception404) {
        echo '<h1>Ошибка 404</h1>';
    } else {
        echo "<h1>Exception detected!</h1>";
        echo '<h2>' . $exception->getMessage() . "</h2><br>";
        foreach ($exception->getTrace() as $row) {
            echo 'File: '. $row['file'] . ', line' . $row['line'] . ', function ' . $row['function'] . '<br>';
        }
    }
});

spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    $className = str_replace('app/', '', $className);
    $file = __DIR__ .  '/../'.  str_replace('\\', '/', $className) . '.php';
    if (is_file($file)) {
        require_once $file;
    } else {
        $no_such_file_debug_break = true;
    }
});

$router = new Router();
$router->parseUri();
if (is_null($router->getController()) && is_null($router->getAction())) {
    $url = 'http://'. $_SERVER['SERVER_NAME'] . Router::getUrl('Site', 'Index');
    header("Location: {$url}");
    exit;
}

$controller = Controller::getInstance($router);
echo $controller->doAction();
