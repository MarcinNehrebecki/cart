<?php


namespace Controller;


class CartController
{
    public function getCart(): string
    {
        $cart = unserialize($_SESSION["cart"]);
        return print_r($cart, true);
    }
}