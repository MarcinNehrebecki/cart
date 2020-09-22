<?php

use Cart\Cart;
use Controller\CartController;
use Repository\CatalogRepository;

session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
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

    } else {
        $cart = new Cart();
    }
    try {
        $cartController = new CartController($cart);
        $catalogRepository = new CatalogRepository();

        switch ($class) {
            case 'cart':
                $message = $cartController->getCart();
                break;
            case 'addProduct':
                if (isset($uri[3])) {
                    $productId = (int)$uri[3];
                    $product = $catalogRepository->getCatalogOnId($productId);
                    $cart = $cartController->addProduct($product);
                    $_SESSION['cart'] = serialize($cart);
                    $message = 'Product Added';
                }
                break;
            case 'deleteProduct':
                if (isset($uri[3])) {
                    $catalogNumberInCart = (int)$uri[3];
                    $cart = $cartController->deleteProduct($catalogNumberInCart);
                    $_SESSION['cart'] = serialize($cart);
                    $message = 'Product Deleted';
                }
                break;
            case 'addFixture':
                if (isset($uri[3])) {
                    $catalogNumberInCart = (int)$uri[3];
                    $message = $catalogRepository->setOneCatalogToDataBase($catalogNumberInCart);
                } else {
                    $message = $catalogRepository->setAllCatalogToDatabase();
                }
                break;
            case 'deleteCatalogInDataBse':
                if (isset($uri[3]) && isset($uri[4])) {
                    $catalogId = (int)$uri[4];
                    if(1 === (int)$uri[3]) {
                        $message = $catalogRepository->deleteCatalogOnId($catalogId);
                    } elseif(0 === (int)$uri[3]) {
                        $message = $catalogRepository->deleteSoftCatalogOnId($catalogId);
                    }
                }
                break;
            case 'changeName':
                if (isset($uri[3]) && isset($uri[4])) {
                    $catalogId = (int)$uri[3];
                    $newName = (string)$uri[4];
                    $message = $catalogRepository->changeNameInCatalog($catalogId, $newName);
                }
                break;
            case 'changePrice':
                if (isset($uri[3]) && isset($uri[4])) {
                    $catalogId = (int)$uri[3];
                    $newPrice = (int)($uri[4] * 100);
                    $message = $catalogRepository->changePriceInCatalog($catalogId, $newPrice);
                }
                break;
            case 'catalog':
                $offset = 0;
                if(isset($_GET['offset'])) {
                    $offset = (int)$_GET['offset'];
                }
                $message = $cartController->prepareShowCatalogEntity($catalogRepository->getCatalogCollection($offset));

                break;
            default:
                $message = 'Wrong Request';
                break;
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
    print \json_encode($message, JSON_PRETTY_PRINT);
}


