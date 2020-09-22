<?php


namespace CatalogCollection;


use CatalogEntity;

class CatalogCollection implements CatalogCollectionInterface
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
     * @param CatalogEntity $catalog
     */
    public function addToCollection(CatalogEntity $catalog): void
    {
        $this->collection[] = $catalog;
    }

    public function setCollection(array $collection): void
    {
        $this->collection = $collection;
    }

    /**
     * @param int $key
     */
    public function removeCatalog(int $key): void
    {
        unset($this->collection[$key]);
    }

    /**
     * @param int $key
     * @return CatalogEntity
     */
    public function getCatalog(int $key): CatalogEntity
    {
        return $this->collection[$key];
    }


}