<?php


class MySQLConnection
{
    private mysqli $connection;
    private static ?MySQLConnection $_instance = null;
    private string $host;
    private string $username;
    private string $password;
    private string $database;

    private function __construct()
    {
        $db = include_once "../../config/database.php";

        $this->host = $db['mysql']['host'];
        $this->username = $db['mysql']['username'];
        $this->password = $db['mysql']['password'];
        $this->database = $db['mysql']['database'];

        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

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