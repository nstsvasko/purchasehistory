<?php

namespace Tea\PurchaseHistory\ReadModel;

use Doctrine\DBAL\Connection;

abstract class AbstractReadModel
{

    /**
     * @param Connection $connection
     * @param string $databasePrefix
     */
    public function __construct(
        private readonly Connection $connection,
        private readonly string $databasePrefix
    )
    {
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getDatabasePrefix(): string
    {
        return $this->databasePrefix;
    }
}
