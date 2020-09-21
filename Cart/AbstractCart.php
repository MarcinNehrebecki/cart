<?php


namespace Cart;


use ProductCollection\ProductCollection;

abstract class AbstractCart
{
    const MAX_PRODUCT_ON_CART = 3;
    protected ProductCollection $listOfClassCollection;
}