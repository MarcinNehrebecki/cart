<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(__DIR__ . '/vendor/autoload.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
if (isset($uri[2])) {
    $message = '';
    $class = $uri[2];
    if (isset($_SESSION["cart"])) {
        $cart = unserialize($_SESSION["cart"]);
        //$cart = new \Cart\Cart();
    } else {
        $cart = new \Cart\Cart();

    }
    try {
        switch ($class) {
            case 'cart':
                $cartController = new \Controller\CartController();
                $message = $cartController->getCart();
                break;
            case 'addProduct':
                if (isset($uri[3]) and (int)$uri[3]) {
                    $productsList = new \Product\ProductList();
                    $product = $productsList->getProduct($uri[3]);
                    $cart->addProductToCollection($product);
                    $_SESSION['cart'] = serialize($cart);
                    $message = 'Product Added';
                }
                break;
            default:
                $productsList = new \Product\ProductList();
                $message = $productsList->getProducts();
                break;
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
    print \json_encode($message, JSON_PRETTY_PRINT);
}


