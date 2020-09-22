<?php


namespace Controller;


use Cart\Cart;
use CatalogCollection\CatalogCollection;
use CatalogEntity;

class CartController
{
    /**
     * @var Cart
     */
    private Cart $cart;

    public function __construct()
    {
        if (isset($_SESSION["cart"])) {
            $cart = unserialize($_SESSION["cart"]);
        } else {
            $cart = new Cart();
        }
        $this->cart = $cart;
    }

    /**
     * @return array
     */
    public function getCart(): array
    {
        return $this->cartToShow();
    }

    /**
     * @param CatalogEntity $catalog
     * @return Cart
     * @throws \Exception
     */
    public function addProduct(CatalogEntity $catalog): Cart
    {
        $this->cart->addProductToCollection($catalog);
        return $this->cart;
    }

    /**
     * @param int $productNumberInCart
     * @return Cart
     */
    public function deleteProduct(int $productNumberInCart): Cart
    {
        $this->cart->deleteProduct($productNumberInCart);
        return $this->cart;
    }

    /**
     * @return array
     */
    private function cartToShow(): array
    {
        $data = $this->prepareShowCatalogEntity($this->cart->getProductsList(), true);
        $data['cart']['sumPrice'] = $this->cart->getPriceAllProduct() / 100;
        return $data;
    }

    /**
     * @param CatalogCollection $listCatalogEntity
     * @param bool $useCart
     * @return array
     */
    public function prepareShowCatalogEntity(CatalogCollection $listCatalogEntity, bool $useCart = false): array
    {
        $data = ['cart' => []];
        /** @var CatalogEntity $catalog */
        foreach ($listCatalogEntity->getCollection() as $key =>  $catalog) {
            $data['cart']['products'][$useCart ? $key : $catalog->getId()] = [
                'name' => $catalog->getName(),
                'price' => $catalog->getPrice() / 100,
                'currency' => $catalog->getCurrency(),
            ];
        }
        return $data;
    }
}