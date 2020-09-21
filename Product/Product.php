<?php

namespace Product;

class Product extends AbstractProduct implements ProductInterface
{

    /**
     * GetPrice on cents
     * @return int
     */
    public function getPrice(): int
    {
        // TODO: Implement getPrice() method.
    }

    /**
     * Get name product
     * @return string
     */
    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        // TODO: Implement getCurrency() method.
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}