<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use App\Database;

// Initialize database connection
$db = new Database();

// Parse URL
$url = isset($_GET['url']) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : ['home'];

// Route the request
$controllerName = ucfirst($url[0]) . 'Controller';
$methodName = isset($url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

// Load controller
$controllerPath = 'classes/Controllers/' . $controllerName . '.php';
if (file_exists($controllerPath)) {
    require_once $controllerPath;
    $controller = new $controllerName($db);
    
    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        require_once 'views/errors/404.php';
    }
} else {
    require_once 'views/errors/404.php';
}