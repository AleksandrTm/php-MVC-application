<?php

include "../";

class MySQLConnection
{
    private mysqli $connection;
    private static ?MySQLConnection $_instance = null;
    private string $host = "192.168.10.10";
    private string $username = "homestead";
    private string $password = "secret";
    private string $database = "content";

    private function __construct()
    {
        $this->connection = new mysqli($this->host, $this->username,
            $this->password, $this->database);

        if (mysqli_connect_error()) {
            trigger_error("Ошибка подключения MySQL: " . mysqli_connect_error());
        }
    }

    public static function getInstance(): MySQLConnection
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    private function __clone()
    {
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}