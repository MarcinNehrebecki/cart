<?php


namespace Repository;


use CatalogCollection\CatalogCollection;
use CatalogEntity;
use DataBaseConnection\ConnectionToDb;
use Product\ProductList;

class CatalogRepository
{

    /**
     * @param int $catalogId
     * @return CatalogEntity
     * @throws \Exception
     */
    public function getCatalogOnId(int $catalogId): CatalogEntity
    {
        $sql = 'select * from catalog.catalog where id = ?';
        $connection = new ConnectionToDb();
        $pdo = $connection->getConnectionDatabase();
        $statement = $pdo->prepare($sql);
        $sta = $statement->execute([$catalogId]);
        if (false === $sta) {
            throw new \Exception('Wrong Id');
        }
        $data = $statement->fetch(\PDO::FETCH_NUM);
        $catalog = new CatalogEntity(...$data);
        return $catalog;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return CatalogCollection
     * @throws \Exception
     */
    public function getCatalogCollection(int $offset = 0, int $limit = 3): CatalogCollection
    {
        $sql = 'select * from catalog.catalog where deleted is null LIMIT ? OFFSET ?';

        $connection = new ConnectionToDb();
        $pdo = $connection->getConnectionDatabase();
        $statement = $pdo->prepare($sql);
        $sta = $statement->execute([$limit, $offset]);
        if (false === $sta) {
            throw new \Exception('Wrong Id');
        }
        $data = $statement->fetchAll(\PDO::FETCH_NUM);
        $catalogCollection  = new CatalogCollection();
        foreach ($data as $row)
        {
            $catalog = new CatalogEntity(...$row);
            $catalogCollection->addToCollection($catalog);
        }
        return $catalogCollection;
    }


    /**
     * @param int $productNumber
     * @return string
     */
    public function setOneCatalogToDataBase(int $productNumber): string
    {
        $productList = new ProductList();
        $product = $productList->getProducts()[$productNumber] ?? null;
        if (null === $product) {
            return 'Wrong Product Number (1-6)';
        }
        $queryValue[] = $product['name'];
        $queryValue[] = \round($product['price']*100);
        $queryValue[] = $product['currency'];

        $sql = 'INSERT INTO catalog.catalog (name, price, currency) VALUES (?, ?, ?)';

        $connection = new ConnectionToDb();
        $pdo = $connection->getConnectionDatabase();
        $statement = $pdo->prepare($sql);
        $sta = $statement->execute($queryValue);
        return $sta ? 'Product added to database' : 'Wrong Product Number (1-6)';
    }


    /**
     *
     */
    public function setAllCatalogToDatabase(): string
    {
        $productList = new ProductList();
        $connection = new ConnectionToDb();
        $pdo = $connection->getConnectionDatabase();
        $products = $productList->getProducts();
        $queryVar = [];
        $queryValue = [];
        foreach ($products as $row) {
            $queryVar[] = '(?,?,?)';
            $queryValue[] = $row['name'];
            $queryValue[] = round($row['price']*100);
            $queryValue[] = $row['currency'];
        }
        $sql = 'INSERT INTO catalog.catalog (name, price, currency) VALUES ' . implode(', ', $queryVar);

        $statement = $pdo->prepare($sql);
        $sta = $statement->execute($queryValue);
        return $sta ? 'Product added to database' : 'Wrong request';
    }

    /**
     * @param int $catalogId
     * @return string
     */
    public function deleteCatalogOnId(int $catalogId): string
    {
        $connection = new ConnectionToDb();
        $pdo = $connection->getConnectionDatabase();
        $sql = 'DELETE FROM catalog.catalog WHERE id = ?';

        $statement = $pdo->prepare($sql);
        $sta = $statement->execute([$catalogId]);
        return $sta ? 'Catalog deleted in database' : 'Wrong request';
    }

    /**
     * @param int $catalogId
     * @return string
     */
    public function deleteSoftCatalogOnId(int $catalogId): string
    {
        $connection = new ConnectionToDb();
        $pdo = $connection->getConnectionDatabase();
        $sql = 'UPDATE catalog.catalog SET deleted = ? WHERE id = ?';

        $statement = $pdo->prepare($sql);
        $sta = $statement->execute([date('Y-m-d H:i:s'),$catalogId]);
        return $sta ? 'Catalog deleted in database' : 'Wrong request';
    }

    /**
     * @param int $catalogId
     * @param $newName
     * @return string
     */
    public function changeNameInCatalog(int $catalogId, $newName): string
    {
        $connection = new ConnectionToDb();
        $pdo = $connection->getConnectionDatabase();
        $sql = 'UPDATE catalog.catalog SET name = ? WHERE id = ?';

        $statement = $pdo->prepare($sql);
        $sta = $statement->execute([$newName, $catalogId]);
        return $sta ? 'Name Changed' : 'Wrong request';
    }

    /**
     * @param int $catalogId
     * @param int $newPrice
     * @return string
     */
    public function changePriceInCatalog(int $catalogId, int $newPrice): string
    {
        $connection = new ConnectionToDb();
        $pdo = $connection->getConnectionDatabase();
        $sql = 'UPDATE catalog.catalog SET price = ? WHERE id = ?';

        $statement = $pdo->prepare($sql);
        $sta = $statement->execute([$newPrice, $catalogId]);
        return $sta ? 'Price Changed' : 'Wrong request';
    }
}