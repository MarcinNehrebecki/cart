<?php


namespace Cart;


use CatalogEntity;
use CatalogCollection\CatalogCollection;

class Cart extends AbstractCart implements CartInterface
{

    public function __construct()
    {
        $this->listOfClassCollection = new CatalogCollection();
    }

    /**
     * Get count of products
     * @return int
     */
    public function getCountProduct(): int
    {
        return $this->listOfClassCollection->count();
    }

    /**
     * Sum price on cents of all products
     * @return int
     */
    public function getPriceAllProduct(): int
    {
        $price = 0;
        /** @var CatalogEntity $catalog */
        foreach ($this->listOfClassCollection->getCollection() as $catalog) {
            $price += $catalog->getPrice();
        }
        return $price;
    }

    /**
     * @param CatalogEntity $catalog
     * @throws \Exception
     */
    public function addProductToCollection(CatalogEntity $catalog): void
    {
        if (self::MAX_PRODUCT_ON_CART > $this->getCountProduct()) {
            $this->listOfClassCollection->addToCollection($catalog);
        } else {
            throw new \Exception('Cart is full');
        }
    }

    /**
     * @param int $productNumber
     */
    public function deleteProduct(int $productNumber): void
    {
        $this->listOfClassCollection->removeCatalog($productNumber);
    }

    /**
     * @return CatalogCollection
     */
    public function getProductsList(): CatalogCollection
    {
        return $this->listOfClassCollection;
    }
}