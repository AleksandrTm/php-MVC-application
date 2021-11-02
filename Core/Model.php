<?php

namespace Core;

use Entities\User;
use Exception;
use mysqli;
use Enums\Database as db;
use mysqli_result;

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
    protected array $appConfig;

    public function __construct()
    {
        $this->db = include "../config/database.php";
        $this->appConfig = include "../config/app.php";

        if ($this->appConfig['database'] === db::MYSQL) {
            $this->mysqlConnect = new mysqli(
                $this->db['mysql']['host'],
                $this->db['mysql']['username'],
                $this->db['mysql']['password'],
                $this->db['mysql']['database'],
            );
        }
        if ($this->appConfig['database'] === db::FILES) {
            $this->filesConnect = $this->db['files']['database'];
        }
    }

    function __clone()
    {
    }

    public function __destruct()
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            $this->mysqlConnect->close();
        }
    }

    /**
     * Получить нужное количество записей из таблицы
     */
    public function getRecordsFromDatabase(string $table, $limitRecordsPage = null): array
    {
        $pagination = new Pagination($table);

        if ($this->appConfig['database'] === db::MYSQL) {
            $this->resultQuery = $this->mysqlConnect->query("SELECT * FROM $table LIMIT $limitRecordsPage OFFSET $pagination->beginWith");
        }
        if ($this->appConfig['database'] === db::FILES) {
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
     * Проверка наличия записи в базе по id
     */
    public function checksExistenceRecord(string $database, int $id): bool
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            return ($this->mysqlConnect->query("SELECT * FROM users WHERE user_id = $id")->num_rows == 1);
        } else {
            return file_exists($database . $id);
        }
    }

    /**
     * Получает текущую роль пользователя из базы данных по id
     */
    public function checksUserRole(string $database, int $id, User $object = null): ?User
    {
        if ($this->checksExistenceRecord($database, $id)) {
            if ($this->appConfig['database'] === db::MYSQL) {
                $result = $this->mysqlConnect->query("SELECT * FROM users WHERE user_id = $id");
                while ($user = $result->fetch_assoc()) {
                    $object->setRole($user['role']);
                }
            }
            if ($this->appConfig['database'] === db::FILES) {
                $file = file_get_contents($database . $id);
                list($login, $password, $email, $fullName, $date, $about, $role) = explode("\n", $file);
                $object->setRole($role);
            }

            return $object;
        }

        return null;
    }

    /**
     * Получаем последний id записи в файлах
     */
    public function getLastId(string $type): int
    {
        $this->getRecordsFromDatabase($type);
        $data = array_keys($this->allData);
        rsort($data);

        return (int)array_shift($data);
    }

    /**
     * Удаление из базы данных записи по id
     */
    public function removeFromTheDatabase(int $id, string $database): void
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            $this->mysqlConnect->query("DELETE FROM users WHERE user_id = $id");
        }
        if ($this->appConfig['database'] === db::FILES) {
            try {
                unlink($database . $id);
            } catch (Exception $e) {
                var_dump($e);
            }
        }
    }

    /**
     * Получает количество значений из таблицы
     */
    public function getTheNumberOfRecords(string $table = null): int
    {
        $count = 0;

        if ($this->appConfig['database'] === db::MYSQL) {
            $count = $this->mysqlConnect->query("SELECT * FROM $table")->num_rows;
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