<?php

namespace Product;

class ProductList
{
    const DEFAULT_CURRENCY = 'PLN';
    private array $products = [
        1 => ['name' => 'The Godfather', 'price' => '59.99', 'currency' => self::DEFAULT_CURRENCY],
        2 => ['name' => 'Steve Jobs', 'price' => '49.99', 'currency' => self::DEFAULT_CURRENCY],
        3 => ['name' => 'The Return of Sherlock Holmes', 'price' => '39.99', 'currency' => self::DEFAULT_CURRENCY],
        4 => ['name' => 'The Little Prince', 'price' => '29.99', 'currency' => self::DEFAULT_CURRENCY],
        5 => ['name' => 'I Hate Myselfie!', 'price' => '19.99', 'currency' => self::DEFAULT_CURRENCY],
        6 => ['name' => 'The Trial', 'price' => '9.99', 'currency' => self::DEFAULT_CURRENCY],
    ];

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}