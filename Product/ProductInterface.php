<?php

namespace Product;

interface ProductInterface
{
    /**
     * GetPrice on cents
     * @return int
     */
    public function getPrice(): int;

    /**
     * Get name product
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getCurrency(): string;
}