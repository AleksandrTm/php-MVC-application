<?php

namespace Core;

use Entities\User;
use Exception;
use mysqli;
use Enums\Database as db;
use config\App;
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

    public function __construct()
    {
        $config = parse_ini_file(db::CONFIG_DB, true);

        if (App::DATABASE === db::MYSQL) {
            $this->mysqlConnect = new mysqli(
                $config['MySQL']['host'],
                $config['MySQL']['username'],
                $config['MySQL']['password'],
                $config['MySQL']['database']);
        }
        if (App::DATABASE === db::FILES) {
            $this->filesConnect = $config['Files']['database'];
        }
    }

    public function __destruct()
    {
        if (App::DATABASE === db::MYSQL) {
            $this->mysqlConnect->close();
        }
    }

    /**
     * Данные из таблицы
     */
    public function getAllDataFromDatabase(string $table): array
    {
        $pagination = new Pagination();
        $pagination->run();

        $limit = App::NUMBER_RECORD_PAGE;

        if (App::DATABASE === db::MYSQL) {
            $this->resultQuery = $this->mysqlConnect->query("SELECT * FROM $table LIMIT $limit OFFSET $pagination->beginWith");
        }
        if (App::DATABASE === db::FILES) {
            try {
                $countFile = 0;

                if ($dir = opendir($table)) {
                    while (($file = readdir($dir)) !== false) {
                        if ($file == '.' || $file == '..') {
                            continue;
                        }
                        /** До куда считываем файлы */
                        if ($limit === 0) {
                            break;
                        }
                        /**От куда начинаем считывать файлы */
                        $countFile++;
                        if ($pagination->beginWith > $countFile) {
                            continue;
                        }
                        $limit--;
                        $this->allData[$file] = file_get_contents($table . $file);
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
        if (App::DATABASE === db::MYSQL) {
            return ($this->mysqlConnect->query("SELECT * FROM users WHERE userId = $id")->num_rows == 1);
        } else {
            return file_exists($database . $id);
        }
    }

    /**
     * Получает текущую роль пользователя из базы данных по id
     */
    public function checksUserRole(string $database, int $id, User $object = null): ?object
    {
        if ($this->checksExistenceRecord($database, $id)) {
            if (App::DATABASE === db::MYSQL) {
                $result = $this->mysqlConnect->query("SELECT * FROM users WHERE userId = $id");
                while ($user = $result->fetch_assoc()) {
                    $object->setRole($user['role']);
                }
            }
            if (App::DATABASE === db::FILES) {
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
        $this->getAllDataFromDatabase($type);
        $data = array_keys($this->allData);
        rsort($data);

        return (int)array_shift($data);
    }

    /**
     * Удаление из базы данных записи по id
     */
    public function removeFromTheDatabase(int $id, string $database): void
    {
        if (App::DATABASE === db::MYSQL) {
            $this->mysqlConnect->query("DELETE FROM users WHERE userId = $id");
        }
        if (App::DATABASE === db::FILES) {
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
    public function getTheNumberOfRecords(string $path = null): int
    {
        $count = 0;

        if (App::DATABASE === db::MYSQL) {
            $count = $this->mysqlConnect->query('SELECT * FROM users')->num_rows;
        }
        if (App::DATABASE === db::FILES) {
            try {
                if ($dir = opendir($path)) {
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