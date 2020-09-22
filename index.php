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
                http_response_code(200);
                break;
            case 'DELETE':
                if ('cart' === $class) {
                    $message = deleteProduct();
                } elseif ('catalog' === $class) {
                    $message = deleteCatalogInDataBse();
                }
                http_response_code(202);

                break;
            case 'PUT':
                if ('catalogName' === $class) {
                    $message = changeName();
                } elseif ('catalogPrice' === $class) {
                    $message = changePrice();
                }
                http_response_code(202);
                break;
            case 'POST':
                if ('catalog' === $class) {
                    $message = addFixture();
                } elseif ('cart' === $class) {
                    $message = addProduct();
                }
                http_response_code(201);
                break;
        }
        if (!is_array($message)) {
            $message = ['message:' => $message];
        }

        if ('' === $message) {
            throw new Exception('Wrong Request');
        }
    } catch (Exception $e) {
        http_response_code(404);
        $message = ['error:' => $e->getMessage()];
    }

    print \json_encode($message, JSON_PRETTY_PRINT);
}

/**
 * @return string
 * @throws Exception
 */
function deleteProduct(): string
{
    $uri = getUri();
    if (!isset($uri[3])) {
        throw new Exception('Wrong Request');
    }

    $cartController = new CartController();
    $catalogNumberInCart = (int)$uri[3];
    $cart = $cartController->deleteProduct($catalogNumberInCart);
    $_SESSION['cart'] = serialize($cart);
    return 'Product Deleted';

}

/**
 * @return string
 * @throws Exception
 */
function deleteCatalogInDataBse(): string
{
    $uri = getUri();
    if (!isset($uri[3]) || !isset($uri[4])) {
        throw new Exception('Wrong Request');
    }
    $catalogRepository = new CatalogRepository();
    $catalogId = (int)$uri[4];
    if (1 === (int)$uri[3]) {
        $message = $catalogRepository->deleteCatalogOnId($catalogId);
    } elseif (0 === (int)$uri[3]) {
        $message = $catalogRepository->deleteSoftCatalogOnId($catalogId);
    } else {
        throw new Exception('Wrong Request');
    }
    return $message;
}

/**
 * @return string
 * @throws Exception
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
    if (!isset($uri[3])) {
        throw new Exception('Wrong Request');
    }
    $uri = getUri();
    $catalogRepository = new CatalogRepository();
    $cartController = new CartController();
    $productId = (int)$uri[3];
    $product = $catalogRepository->getCatalogOnId($productId);
    $cart = $cartController->addProduct($product);
    $_SESSION['cart'] = serialize($cart);

    return 'Product Added';
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
 * @throws Exception
 */
function changeName(): string
{
    $uri = getUri();
    if (!isset($uri[3]) || !isset($uri[4])) {
        throw new Exception('Wrong Request');
    }
    $catalogRepository = new CatalogRepository();
    $catalogId = (int)$uri[3];
    $newName = (string)$uri[4];
    return $catalogRepository->changeNameInCatalog($catalogId, $newName);
}

/**
 * @return string
 * @throws Exception
 */
function changePrice()
{
    if (!isset($uri[3]) || !isset($uri[4])) {
        throw new Exception('Wrong Request');
    }
    $uri = getUri();
    $catalogRepository = new CatalogRepository();

    $catalogId = (int)$uri[3];
    $newPrice = (int)($uri[4] * 100);
    return $catalogRepository->changePriceInCatalog($catalogId, $newPrice);
}

/**
 * @return array
 */
function getUri(): array
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return explode( '/', $uri );
}
