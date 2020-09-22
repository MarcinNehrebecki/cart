<?php

namespace CatalogCollection;

use CatalogEntity;
use PHPUnit\Framework\TestCase;

class CatalogCollectionTest extends TestCase
{

    /**
     * @var CatalogCollection
     */
    private CatalogCollection $catalogCollection;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->catalogCollection = new CatalogCollection();
    }

    public function testCount()
    {
        $this->assertEquals(0,  $this->catalogCollection->count());
        $catalog = new CatalogEntity(1,'test' , 3455, 'PLN');
        $this->catalogCollection->addToCollection($catalog);
        $this->assertEquals(1,  $this->catalogCollection->count());
    }

    public function testGetCollection()
    {
        $catalog = new CatalogEntity(1,'test' , 3455, 'PLN');
        $this->catalogCollection->addToCollection($catalog);
        $this->assertIsArray($this->catalogCollection->getCollection());
    }

    public function testClear()
    {
        $catalog = new CatalogEntity(1,'test' , 3455, 'PLN');
        $this->catalogCollection->addToCollection($catalog);
        $this->catalogCollection->clear();
        $this->assertEquals(0,  $this->catalogCollection->count());

    }

    public function testAddToCollection()
    {
        $catalog = new CatalogEntity(1,'test' , 3455, 'PLN');
        $this->catalogCollection->addToCollection($catalog);
        $this->assertEquals(1,  $this->catalogCollection->count());
    }

    public function testSetCollection()
    {
        $catalog = new CatalogEntity(1,'test' , 3455, 'PLN');
        $catalog2 = new CatalogEntity(2,'test' , 3455, 'PLN');
        $this->catalogCollection->setCollection([$catalog, $catalog2]);
        $this->assertEquals(2,  $this->catalogCollection->count());
    }

    public function testRemoveCatalog()
    {
        $catalog = new CatalogEntity(1,'test' , 3455, 'PLN');
        $this->catalogCollection->addToCollection($catalog);
        $this->catalogCollection->removeCatalog(0);
        $this->assertEquals(0,  $this->catalogCollection->count());
    }

    public function testGetCatalog()
    {
        $catalog = new CatalogEntity(1,'test' , 3455, 'PLN');
        $this->catalogCollection->addToCollection($catalog);
        $catalog2 = $this->catalogCollection->getCatalog(0);
        $this->assertEquals($catalog->getName(), $catalog2->getName());
        $this->assertEquals($catalog->getPrice(), $catalog2->getPrice());
        $this->assertEquals($catalog->getCurrency(), $catalog2->getCurrency());

    }
}