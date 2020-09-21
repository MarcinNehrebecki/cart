<?php


namespace Cart;


use Product\Product;
use ProductCollection\ProductCollection;

class Cart extends AbstractCart implements CartInterface
{

    public function __construct()
    {
        $this->listOfClassCollection = new ProductCollection();
    }

    /**
     * Get count of products
     * @return int
     */
    public function getCountProduct(): int
    {
        return $this->listOfClassCollection->count();
    }

    /**
     * Sum price on cents of all products
     * @return int
     */
    public function getPriceAllProduct(): int
    {
        $price = 0;
        /** @var Product $product */
        foreach ($this->listOfClassCollection->getCollection() as $product) {
            $price += $product->getPrice();
        }
        return $price;
    }

    public function addProductToCollection(Product $product): void
    {
        if (self::MAX_PRODUCT_ON_CART > $this->getCountProduct()) {
            $this->listOfClassCollection->addToCollection($product);
        } else {
            throw new \Exception('Cart is full');
        }
    }

}