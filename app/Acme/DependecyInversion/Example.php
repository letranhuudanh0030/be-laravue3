<?php

interface ConnectionInterface {
    public function connect();
}

class DbConnection implements ConnectionInterface{
    public function connect()
    {
        # code...
    }
}

class PasswordReminder {
    /**
     * @var MySQLConnection
     */
    private $dbConnection;

    public function __construct(ConnectionInterface $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }
}
