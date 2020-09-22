<?php


namespace CatalogCollection;


use CatalogEntity;

interface CatalogCollectionInterface
{
    public function count(): int;
    public function getCollection(): array;
    public function clear(): void;
    public function addToCollection(CatalogEntity $catalog): void;
    public function setCollection(array $collection): void;
    public function removeCatalog(int $key): void;
    public function getCatalog(int $key): CatalogEntity;

}