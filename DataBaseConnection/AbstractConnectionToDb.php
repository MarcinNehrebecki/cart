<?php


namespace DataBaseConnection;

use PDO;
use PDOStatement;

/**
 * Class AbstractConnectionToDb
 * @package dataBaseConnection
 */
abstract class AbstractConnectionToDb
{

    /** @var string  */
    protected string $username;
    /** @var string  */
    protected string $password;
    /** @var string  */
    protected string $databaseDsn;
    /** @var  */
    private PDO $connectionDatabase;

    /**
     * connect
     */
    protected function connect(): string
    {
        try {
            $this->connectionDatabase = new PDO(
                $this->databaseDsn,
                $this->username,
                $this->password,
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            return "Connected successfully to";
        } catch(\PDOException $e) {
            return  "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * @return PDO
     */
    public function getConnectionDatabase(): PDO
    {
        return $this->connectionDatabase;
    }

    /**
     * Method overwrites default prepare for version purposes.
     *
     * @param string $query
     * @return PDOStatement|null
     */
    public function prepare(string $query): ?PDOStatement
    {
        return $this->connectionDatabase->prepare($query);
    }
}