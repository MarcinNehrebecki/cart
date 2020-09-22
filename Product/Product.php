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
        return $this->price;
    }

    /**
     * Get name product
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
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