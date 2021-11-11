<?php

namespace Models;

use Core\Pagination;
use Enums\Database as db;
use Exception;
use Entities\User;
use Core\Model;
use Enums\Paths;
use Interfaces\UserInterface;
use Throwable;


class UserModel extends Model implements UserInterface
{
    /**
     * Отдаёт многомерный массив со всеми пользователями и данными
     * [idUser => ['login' => $login, 'password' => $password, ...], ...]
     */
    public function getDataUsers(): array
    {
        $userInfo = [];

        $this->getRecordsFromDatabase(db::USERS);

        foreach ($this->allData as $userId => $userData) {
            list($login, $password, $email, $fullName, $date, $about, $role) = explode("\n", $userData);

            $userInfo[$userId] = [
                'login' => $login,
                'password' => $password,
                'email' => $email,
                'fullName' => $fullName,
                'date' => $date,
                'about' => $about,
                'role' => $role,
            ];
        }

        return $userInfo;
    }

    /**
     * Получает текущую роль пользователя из базы данных по id
     */
    public function checksUserRole(string $database, int $id, User $object = null): ?User
    {
        if ($this->checksExistenceRecord($database, $id)) {
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
     * Получаем данные о пользователе по логину
     */
    public function getDataForAuthorization(string $login): ?array
    {
        return [];
    }

    /**
     * Получаем данные о пользователе по логину
     */
    public function getDataUser(int $id): ?array
    {
        return [];
    }

    /**
     * Добавление пользователя
     */
    public function addUser(User $user): bool
    {
        $status = false;

        if ($this->appConfig['database'] === db::FILES) {
            if (empty($this->getLastId(Paths::DIR_BASE_USERS))) {
                $userId = 1;
            } else {
                $userId = ($this->getLastId(Paths::DIR_BASE_USERS) + 1);
            }
            $status = $this->writingDatabase($user, $userId, Paths::DIR_BASE_USERS);
        }

        return $status;
    }

    /**
     * Редактирование пользователя
     *
     * провера на существования пользователя с переданным id
     */
    public function editUser(User $user, int $id): void
    {
        if ($this->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
            $this->writingDatabase($user, $id, Paths::DIR_BASE_USERS);
        }
    }

    /**
     * Записывает переданные данные в базу данных
     */
    public function writingDatabase(User $user, int $id = null, string $database = null, string $update = null): bool
    {
        $files = null;

        try {
            $files = fopen($database . $id, 'w');
            fwrite($files, $user->getLogin() . "\n");
            fwrite($files, password_hash($user->getPassword(), PASSWORD_DEFAULT) . "\n");
            fwrite($files, $user->getEmail() . "\n");
            fwrite($files, $user->getFullName() . "\n");
            fwrite($files, $user->getDate() . "\n");
            fwrite($files, $user->getAbout() . "\n");
            fwrite($files, 'member');
        } catch (Exception $e) {
            var_dump($e);
            return false;
        } finally {
            fclose($files);
        }

        return true;
    }
}