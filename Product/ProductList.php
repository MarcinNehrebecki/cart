<?php

namespace Product;

use Exception;

class ProductList
{
    const DEFAULT_CURRENCY = 'PLN';
    private array $products = [
        1 => ['name' => 'The Godfather', 'price' => '59,99', 'currency' => self::DEFAULT_CURRENCY],
        2 => ['name' => 'Steve Jobs', 'price' => '49,99', 'currency' => self::DEFAULT_CURRENCY],
        3 => ['name' => 'The Return of Sherlock Holmes', 'price' => '39,99', 'currency' => self::DEFAULT_CURRENCY],
        4 => ['name' => 'The Little Prince', 'price' => '29,99', 'currency' => self::DEFAULT_CURRENCY],
        5 => ['name' => 'I Hate Myselfie!', 'price' => '19,99', 'currency' => self::DEFAULT_CURRENCY],
        6 => ['name' => 'The Trial', 'price' => '9,99', 'currency' => self::DEFAULT_CURRENCY],
    ];

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param $key
     * @return Product
     * @throws Exception
     */
    public function getProduct($key): Product
    {
        if (!isset($this->products[$key])) {
            throw new Exception('Product is not Isset', 404);
        }

        $product = new Product();
        $product->setName($this->products[$key]['name']);
        $product->setCurrency($this->products[$key]['currency']);
        $product->setPrice($this->getPriceIntOnString($this->products[$key]['price']));

        return $product;
    }

    /**
     * @param string $price
     * @return int
     */
    public function getPriceIntOnString(string $price): int
    {
        return (int)((float)$price * 100);
    }
}