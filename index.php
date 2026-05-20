<?php
session_start();

require_once 'config/database.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action     = isset($_GET['action'])     ? $_GET['action']     : 'index';

$controllerMap = [
    'home'    => 'HomeController',
    'product' => 'ProductController',
    'about'   => 'AboutController',
    'auth'    => 'AuthController',
    'cart'    => 'CartController',
    'order'   => 'OrderController',
    'admin'   => 'AdminController',
    'post'    => 'PostController',
    'page'    => 'PageController',
];

$controllerName = isset($controllerMap[$controller]) ? $controllerMap[$controller] : 'HomeController';
$controllerFile = 'controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerInstance = new $controllerName($conn);

    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        $controllerInstance->index();
    }
} else {
    die("Không tìm thấy controller: " . $controllerFile);
}
?>
