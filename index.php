<?php

use Controller\CartController;
use Repository\CatalogRepository;

session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(__DIR__ . '/vendor/autoload.php');

$uri = getUri();

if (isset($uri[2])) {
    $message = 'Wrong Request';
    $class = (string)$uri[2];
    try {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if ('catalog' === $class) {
                    $message = catalog();
                } elseif ('cart' === $class) {
                    $message = cart();
                }
                break;
            case 'DELETE':
                if ('cart' === $class) {
                    $message = deleteProduct();
                } elseif ('catalog' === $class) {
                    $message = deleteCatalogInDataBse();
                }
                break;
            case 'PUT':
                if ('catalogChangeName' === $class) {
                    $message = changeName();
                } elseif ('catalogChangePrice' === $class) {
                    $message = changePrice();
                }
                break;
            case 'POST':
                if ('catalog' === $class) {
                    $message = addFixture();
                } elseif ('cart' === $class) {
                    addProduct();
                }
                break;
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
    }

    print \json_encode($message, JSON_PRETTY_PRINT);
}

/**
 * @return string
 */
function deleteProduct(): string
{
    $uri = getUri();
    if (!isset($uri[3])) {
        return 'Wrong Request';
    }

    $cartController = new CartController();
    $catalogNumberInCart = (int)$uri[3];
    $cart = $cartController->deleteProduct($catalogNumberInCart);
    $_SESSION['cart'] = serialize($cart);
    return 'Product Deleted';

}

/**
 * @return string
 */
function deleteCatalogInDataBse(): string
{
    $uri = getUri();
    $message = 'Wrong Request';
    if (!isset($uri[3]) || !isset($uri[4])) {
        return $message;
    }
    $catalogRepository = new CatalogRepository();
    $catalogId = (int)$uri[4];
    if (1 === (int)$uri[3]) {
        $message = $catalogRepository->deleteCatalogOnId($catalogId);
    } elseif (0 === (int)$uri[3]) {
        $message = $catalogRepository->deleteSoftCatalogOnId($catalogId);
    }

    return $message;
}

/**
 * @return string
 */
function addFixture(): string
{
    $uri = getUri();
    $catalogRepository = new CatalogRepository();
    if (isset($uri[3])) {
        $catalogNumberInCart = (int)$uri[3];
        $message = $catalogRepository->setOneCatalogToDataBase($catalogNumberInCart);
    } else {
        $message = $catalogRepository->setAllCatalogToDatabase();
    }

    return $message;
}

/**
 * @return array
 * @throws Exception
 */
function catalog(): array
{
    $catalogRepository = new CatalogRepository();
    $cartController = new CartController();
    $offset = 0;
    if(isset($_GET['offset'])) {
        $offset = (int)$_GET['offset'];
    }
    return $cartController->prepareShowCatalogEntity($catalogRepository->getCatalogCollection($offset));
}

/**
 * @return string
 * @throws Exception
 */
function addProduct(): string
{
    $uri = getUri();
    $catalogRepository = new CatalogRepository();
    $cartController = new CartController();
    $message = 'Wrong Request';
    if (isset($uri[3])) {
        $productId = (int)$uri[3];
        $product = $catalogRepository->getCatalogOnId($productId);
        $cart = $cartController->addProduct($product);
        $_SESSION['cart'] = serialize($cart);
        $message = 'Product Added';
    }

    return $message;
}

/**
 * @return array
 */
function cart(): array
{
    $cartController = new CartController();
    return $cartController->getCart();
}

/**
 * @return string
 */
function changeName(): string
{
    $uri = getUri();
    $message = 'Wrong Request';
    $catalogRepository = new CatalogRepository();
    if (isset($uri[3]) && isset($uri[4])) {
        $catalogId = (int)$uri[3];
        $newName = (string)$uri[4];
        $message = $catalogRepository->changeNameInCatalog($catalogId, $newName);
    }
    return $message;
}

/**
 * @return string
 */
function changePrice()
{
    $uri = getUri();
    $message = 'Wrong Request';
    $catalogRepository = new CatalogRepository();
    if (isset($uri[3]) && isset($uri[4])) {
        $catalogId = (int)$uri[3];
        $newPrice = (int)($uri[4] * 100);
        $message = $catalogRepository->changePriceInCatalog($catalogId, $newPrice);
    }
    return $message;
}

/**
 * @return array
 */
function getUri(): array
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return explode( '/', $uri );
}


