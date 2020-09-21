<?php


namespace Cart;


interface CartInterface
{
    /**
     * Get count of products
     * @return int
     */
    public function getCountProduct(): int;

    /**
     * Sum price on cents of all products
     * @return int
     */
    public function getPriceAllProduct(): int;


}