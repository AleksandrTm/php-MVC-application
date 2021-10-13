<?php

namespace src\Model;

use Exception;
use Config\Paths;

class Users
{
    static function viewsUsers(): array
    {
        $arrayUsers = [];
        $dir = null;
        try {
            if ($dir = opendir(Paths::DIR_BASE_USERS)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == '.' || $file == '..') {
                        continue;
                    }
                    $nameKey = "user-id-" . $file;
                    $arrayUsers[$nameKey] = file(Paths::DIR_BASE_USERS . $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                }
            }
        } catch (Exception $e) {
            var_dump($e);
        } finally {
            closedir($dir);
        }
        sort($arrayUsers);
        var_dump($arrayUsers);
        return $arrayUsers;
    }


    /**
     *
     * Добавление пользователя в файловую базу данных
     *
     * @param string $name
     * @param string $password
     * @param string $email
     * @param string $fullName
     * @param string $date
     * @param string $about
     *
     */
    static function addUser(string $name, string $password, string $email, string $fullName, string $date, string $about): void
    {
        $files = null;
        if (empty(Users::idUser())) {
            $userId = Paths::DIR_BASE_USERS . 1;
        } else {
            $userId = Paths::DIR_BASE_USERS . (Users::idUser() + 1);
        }
        try {
            $files = fopen($userId, 'w');
            fwrite($files, $name . "\n");
            fwrite($files, $password . "\n");
            fwrite($files, $email . "\n");
            fwrite($files, $fullName . "\n");
            fwrite($files, $date . "\n");
            fwrite($files, $about);
        } catch (Exception $e) {
            var_dump($e);
        } finally {
            fclose($files);
        }
    }

    /**
     *
     * Редактирование пользователя
     *
     * @param int $id
     * @param string $name
     * @param string $password
     * @param string $email
     * @param string $fullName
     * @param string $date
     * @param string $about
     *
     */
    static function editUser(int $id, string $name, string $password, string $email, string $fullName, string $date, string $about): void
    {
        $files = null;
        try {
            $files = fopen($id, 'w');
            fwrite($files, $name . "\n");
            fwrite($files, $password . "\n");
            fwrite($files, $email . "\n");
            fwrite($files, $fullName . "\n");
            fwrite($files, $date . "\n");
            fwrite($files, $about);
        } catch (Exception $e) {
            var_dump($e);
        } finally {
            fclose($files);
        }
    }

    /**
     * Заносим в массив пользователей,
     * сортируем по убыванию и отдаём последний id пользователя
     */
    static function idUser(): int
    {
        $arrayUsers = [];
        $dir = null;
        try {
            if ($dir = opendir(Paths::DIR_BASE_USERS)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == '.' || $file == '..') {
                        continue;
                    }
                    $arrayUsers[] = $file;
                }
            }
        } catch (Exception $e) {
            var_dump($e);
        } finally {
            closedir($dir);
        }
        rsort($arrayUsers);
        return array_shift($arrayUsers);
    }
}