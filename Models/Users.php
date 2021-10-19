<?php

namespace Models;

use Exception;
use config\Paths;
use Core\Model;

class Users extends Model
{
    /**
     * Отдаёт многомерный массив со всеми пользователями и данными
     * [[KeyIdUser => Values][KeyIdUser => Values]]
     */
    function views(): ?array
    {
        foreach ($this->data as $file) {
            $arrayUsers[] = [$file => file(Paths::DIR_BASE_USERS . $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)];
        }
        return $arrayUsers ?? null;
    }


    /**
     * Используем views для получения пользователей,
     * и отдаём массив пользователей [login, password]
     */
    function userLoginPassword(): array
    {
        $dataUsers = [];
        $allDataUsers = $this->views();

        foreach ($allDataUsers as $users) {
            foreach ($users as $values) {
                $dataUsers[] = [
                    'login' => $values[0],
                    'password' => $values[1],
                    'role' => $values[6] ?? $values[5]];
            }
        }

        return $dataUsers;
    }

    /**
     * Добавление пользователя
     */
    function add(string $name, string $password, string $email, string $fullName, string $date, string $about): void
    {
        $files = null;
        if (empty($this->id())) {
            $userId = Paths::DIR_BASE_USERS . 1;
        } else {
            $userId = Paths::DIR_BASE_USERS . ($this->id() + 1);
        }
        try {
            $files = fopen($userId, 'w');
            fwrite($files, $name . "\n");
            fwrite($files, password_hash($password, PASSWORD_DEFAULT) . "\n");
            fwrite($files, $email . "\n");
            fwrite($files, $fullName . "\n");
            fwrite($files, $date . "\n");
            fwrite($files, $about . "\n");
            fwrite($files, 'member');
        } catch (Exception $e) {
            var_dump($e);
        } finally {
            fclose($files);
        }
    }

    /**
     *
     * Редактирование пользователя
     */
    function edit(int $id, string $name, string $password, string $email, string $fullName, string $date, string $about): ?string
    {
        $files = null;
        try {
            if ($this->findUser($id)) {
                $files = fopen(Paths::DIR_BASE_USERS . $id, 'w');
                fwrite($files, $name . "\n");
                fwrite($files, password_hash($password, PASSWORD_DEFAULT) . "\n");
                fwrite($files, $email . "\n");
                fwrite($files, $fullName . "\n");
                fwrite($files, $date . "\n");
                fwrite($files, $about);

                return "Пользователь успешно отредактирован";
            }
        } catch (Exception $e) {
            var_dump($e);
        } finally {
            fclose($files);
        }
        return null;
    }

    /**
     * Заносим в массив пользователей,
     * сортируем по убыванию и отдаём последний id пользователя
     */
    function id(): int
    {
        $users = $this->data;
        rsort($users);
        return (int)array_shift($users);
    }

    /**
     * Удаление пользователя по id
     * Добавить проверку на существующего пользователя
     */
    function deleteUser(int $id): void
    {
        try {
            unlink(Paths::DIR_BASE_USERS . $id);
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Поиск пользователя по id
     */
    function findUser(int $id): bool
    {
        return file_exists(Paths::DIR_BASE_USERS . $id);
    }
}