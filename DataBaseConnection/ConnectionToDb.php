<?php

namespace DataBaseConnection;

require_once(__DIR__ . '\..\Config.php');

use Config;

/**
 * Class ConnectionToDb
 * @package dataBaseConnection
 */
class ConnectionToDb extends AbstractConnectionToDb
{
    /** @var string  */
    protected string $username = Config::DB_USER_NAME;
    /** @var string  */
    protected string $password = Config::DB_PASSWORD;
    /** @var string  */
    protected string $dataBaseName = Config::DB_NAME;
    /** @var string  */
    protected string $dbHost = Config::DB_HOST;
    /** @var int  */
    protected int $port = Config::DB_PORT;
    /** @var string  */
    protected string $databaseDsn;

    /**
     * ConnectionToDb constructor.
     */
    public function __construct()
    {
        $this->databaseDsn = 'mysql:host='.$this->dbHost.';dbname='.$this->dataBaseName;
        $this->connect();
    }
}