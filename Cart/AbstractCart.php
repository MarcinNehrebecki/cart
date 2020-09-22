<?php


namespace Cart;


use CatalogCollection\CatalogCollection;

abstract class AbstractCart
{
    const MAX_PRODUCT_ON_CART = 3;
    protected CatalogCollection $listOfClassCollection;
}