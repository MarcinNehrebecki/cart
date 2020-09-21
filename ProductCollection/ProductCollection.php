<?php


namespace ProductCollection;


use Product\Product;

class ProductCollection implements ProductCollectionInterface
{
    /** @var array  */
    protected array $collection = [];

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->collection);
    }

    /**
     * @return array
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * Clear
     */
    public function clear(): void
    {
        unset($this->collection);
        $this->collection = [];
    }

    /**
     * @param Product $product
     */
    public function addToCollection(Product $product): void
    {
        $this->collection[] = $product;
    }

    public function setCollection(array $collection): void
    {
        $this->collection = $collection;
    }

    /**
     * @param int $key
     */
    public function removeProduct(int $key): void
    {
        unset($this->collection[$key]);
    }

    /**
     * @param int $key
     * @return Product
     */
    public function getProduct(int $key): Product
    {
        return $this->collection[$key];
    }


}