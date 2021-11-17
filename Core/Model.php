<?php

namespace Core;

use Error;
use Exception;
use mysqli;
use Enums\Database as db;
use mysqli_result;
use Core\Connections\MySQLConnection;
use Throwable;

/**
 * Базовая модель
 */
class Model
{
    protected array $allData = [];
    protected string $filesConnect;
    protected mysqli $mysqlConnect;
    protected mysqli_result $resultQuery;
    protected array $db;
    public array $appConfig;

    public function __construct()
    {
        try {
            $this->appConfig = include "../config/app.php";

            if ($this->appConfig['database'] === db::MYSQL) {
                $this->mysqlConnect = MySQLConnection::getInstance()->getConnection();

            }
            if ($this->appConfig['database'] === db::FILES) {
                $this->db = include "../config/database.php";
                $this->filesConnect = $this->db['files']['database'];
            }
        } catch (Error | Exception | Throwable $t) {
        }
    }

    /**
     * Получить нужное количество записей из таблицы
     */
    public function getRecordsFromDatabase(string $table): array
    {
        if ($this->appConfig['database'] === db::FILES) {
            $limitRecordsPage = $this->appConfig['number_record_page'];
            $pagination = new Pagination($table);

            try {
                $countFile = 0;

                if ($dir = opendir($this->filesConnect . $table . '/')) {
                    while (($file = readdir($dir)) !== false) {
                        if ($file == '.' || $file == '..') {
                            continue;
                        }
                        /** До куда считываем файлы */
                        if ($limitRecordsPage === 0) {
                            break;
                        }
                        /** От куда начинаем считывать файлы */
                        $countFile++;
                        if ($pagination->beginWith > $countFile) {
                            continue;
                        }
                        $limitRecordsPage--;
                        $this->allData[$file] = file_get_contents($this->filesConnect . $table . '/' . $file);
                    }
                }
            } catch (Exception $e) {
                var_dump($e);
            } finally {
                closedir($dir ?? null);
            }

        }
        return $this->allData;
    }

    /**
     * Проверка наличия пользователя в базе по id
     */
    public function checksExistenceRecord(string $database, $id): bool
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            try {
                return ($this->mysqlConnect->query("SELECT * FROM users WHERE user_id = $id")->num_rows === 1);
            } catch (Throwable $t) {
            }
        } else {
            return file_exists($database . $id);
        }

        return false;
    }

    /**
     * Получаем последний id записи в файлах
     */
    public function getLastId(string $type): int
    {
        $arr = array_diff(scandir($this->filesConnect . $type), array('..', '.'));
        rsort($arr);
        return (int)array_shift($arr);
    }

    /**
     * Удаление из базы данных записи по id
     */
    public function removeFromTheDatabase(int $id, string $database): string
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            try {
                $this->mysqlConnect->query("DELETE FROM users WHERE user_id = $id");
            } catch (Throwable $t) {
                return false;
            }
        }
        if ($this->appConfig['database'] === db::FILES) {
            try {
                unlink($database . $id);
            } catch (Exception $e) {
                var_dump($e);
                return false;
            }
        }

        return true;
    }

    /**
     * Получает количество значений из таблицы
     */
    public function getTheNumberOfRecords(string $table = null): int
    {
        $count = 0;
        $currentTime = date(("Y-m-d H:i:s"));

        if ($this->appConfig['database'] === db::MYSQL) {
            try {
                if ($table === db::NEWS) {
                    $count = $this->mysqlConnect->query("SELECT * FROM news WHERE date > '$currentTime'")->num_rows;
                } else {
                    $count = $this->mysqlConnect->query("SELECT * FROM $table")->num_rows;
                }
            } catch (Throwable $t) {
//                var_dump($t);
            }
        }
        if ($this->appConfig['database'] === db::FILES) {
            try {
                if ($dir = opendir($this->filesConnect . $table)) {
                    while (($file = readdir($dir)) !== false) {
                        if ($file == '.' || $file == '..') {
                            continue;
                        }
                        $count++;
                    }
                }
            } catch (Exception $e) {
                var_dump($e);
            } finally {
                closedir($dir ?? null);
            }
        }

        return $count;
    }

    public function writeToDatabase(string $sql)
    {
        $this->mysqlConnect->query($sql);
    }
}