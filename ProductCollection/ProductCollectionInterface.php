<?php


namespace ProductCollection;


use Product\Product;

interface ProductCollectionInterface
{
    public function count(): int;
    public function getCollection(): array;
    public function clear(): void;
    public function addToCollection(Product $product): void;
    public function setCollection(array $collection): void;
    public function removeProduct(int $key): void;
    public function getProduct(int $key): Product;

}