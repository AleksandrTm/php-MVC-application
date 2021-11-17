<?php

namespace Core\Connections;

use Error;
use Exception;
use mysqli;
use Enums\Database as path;
use Throwable;

/**
 * Создание подключения к базе данных на Singleton
 */
class MySQLConnection
{
    private mysqli $connection;
    private static ?MySQLConnection $_instance = null;
    private ?string $host = null;
    private ?string $username = null;
    private ?string $password = null;
    private ?string $database = null;

    private function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            if (file_exists(path::PATH_DATABASE) && is_readable(path::PATH_DATABASE)) {
                $db = require_once path::PATH_DATABASE;
            } else {
                $db = NULL;
            }
            if (!empty($db)) {
                $this->host = $db['mysql']['host'];
                $this->username = $db['mysql']['username'];
                $this->password = $db['mysql']['password'];
                $this->database = $db['mysql']['database'];
            }

            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        } catch (Error | Exception | Throwable $t) {

        }
        if (mysqli_connect_error()) {
            trigger_error("Ошибка подключения MySQL: " . mysqli_connect_error());
        }
    }

    public function __destruct()
    {
        if (!mysqli_connect_error()) {
            $this->connection->close();
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