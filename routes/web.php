<?php
// TẠM THỜI COMMENT VÌ ĐÃ XỬ LÝ TRONG INDEX.PHP
/*
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch($controller) {
    case 'home':
        require_once 'controllers/HomeController.php';
        $homeController = new HomeController($conn);
        $homeController->$action();
        break;
        
    case 'product':
        require_once 'controllers/ProductController.php';
        $productController = new ProductController($conn);
        $productController->$action();
        break;
        
    case 'cart':
        require_once 'controllers/CartController.php';
        $cartController = new CartController($conn);
        $cartController->$action();
        break;
        
    case 'auth':
        require_once 'controllers/AuthController.php';
        $authController = new AuthController($conn);
        $authController->$action();
        break;
        
    case 'post':
        require_once 'controllers/PostController.php';
        $postController = new PostController($conn);
        $postController->$action();
        break;
        
    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page not found";
        break;
}
*/
?>