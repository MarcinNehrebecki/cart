<?php

namespace Product;

abstract class AbstractProduct
{
    /** @var int */
    protected int $price;
    /** @var string */
    protected string $currency;
    /** @var string */
    protected string $name;
}
