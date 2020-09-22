<?php


namespace CartTest;


use Cart\Cart;
use CatalogEntity;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /**
     * @var Cart
     */
    private Cart $cart;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->cart = new Cart();
    }

    public function testAddProductToCollection()
    {
        try {
            $catalog = new CatalogEntity(1,'test' , 3455, 'PLN');
            $this->cart->addProductToCollection($catalog);
            $this->assertEquals(1, $this->cart->getCountProduct());
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGetCountProduct()
    {
        $this->assertEquals(0, $this->cart->getCountProduct());
    }

    public function testSetMoreProductToCart()
    {
        try {
            $catalog = new CatalogEntity(1,'test' , 3455, 'PLN');
            $this->cart->addProductToCollection($catalog);
            $this->assertEquals(1, $this->cart->getCountProduct());

            $catalog2 = new CatalogEntity(2,'test' , 3455, 'PLN');
            $this->cart->addProductToCollection($catalog2);

            $catalog3 = new CatalogEntity(3,'test' , 3455, 'PLN');
            $this->cart->addProductToCollection($catalog3);
            $this->assertEquals(3, $this->cart->getCountProduct());

            $catalog4 = new CatalogEntity(4,'test' , 3455, 'PLN');
            $this->cart->addProductToCollection($catalog4);
            $this->assertEquals(3, $this->cart->getCountProduct());

        } catch (\Exception $e) {
            $this->assertEquals('Cart is full' , $e->getMessage());
        }
    }

    public function testDeleteProduct()
    {
        try {
            $catalog = new CatalogEntity(1,'test' , 3455, 'PLN');
            $this->cart->addProductToCollection($catalog);
            $this->assertEquals(1, $this->cart->getCountProduct());

            $catalog2 = new CatalogEntity(2,'test' , 3455, 'PLN');
            $this->cart->addProductToCollection($catalog2);

            $this->assertEquals(2, $this->cart->getCountProduct());

            $this->cart->deleteProduct(1);
            $this->assertEquals(1, $this->cart->getCountProduct());

        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGetProductsList()
    {
        try {
            $catalog = new CatalogEntity(1,'test' , 3, 'PLN');
            $this->cart->addProductToCollection($catalog);

            $catalog2 = new CatalogEntity(2,'test' , 5, 'PLN');
            $this->cart->addProductToCollection($catalog2);

            $catalogCollection = $this->cart->getProductsList();
            $this->assertEquals(2, $catalogCollection->count());
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGetPriceOnAllProductInCart()
    {
        try {
            $catalog = new CatalogEntity(1,'test' , 3, 'PLN');
            $this->cart->addProductToCollection($catalog);

            $catalog2 = new CatalogEntity(2,'test' , 5, 'PLN');
            $this->cart->addProductToCollection($catalog2);

            $this->assertEquals(8, $this->cart->getPriceAllProduct());
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

}