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
     * @return array
     */
    public function getCart(): array
    {
        return $this->cartToShow();
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

    /**
     * @return array
     */
    private function cartToShow(): array
    {
        $data = ['cart' => []];
        /** @var Product $product */
        foreach ($this->cart->getProductsList() as $product) {
            $data['cart']['products'][] = [
                'name' => $product->getName(),
                'price' => $product->getPrice() / 100,
                'currency' => $product->getCurrency(),
            ];
        }
        $data['cart']['sumPrice'] = $this->cart->getPriceAllProduct() / 100;
        return $data;
    }
}