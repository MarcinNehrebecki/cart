<?php


namespace Controller;


use Cart\Cart;
use Product\Product;

class CartController
{
    /**
     * @var Cart
     */
    private Cart $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return string
     */
    public function getCart(): string
    {
        return print_r($this->cart, true);
    }

    /**
     * @param Product $product
     * @return Cart
     * @throws \Exception
     */
    public function addProduct(Product $product): Cart
    {
        $this->cart->addProductToCollection($product);
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
}