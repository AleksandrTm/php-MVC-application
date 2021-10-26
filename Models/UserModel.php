<?php

namespace Models;

use Exception;
use Entities\User;
use Core\Model;
use config\Paths;

class UserModel extends Model
{
    /**
     * Отдаёт многомерный массив со всеми пользователями и данными
     * [idUser => ['login' => $login, 'password' => $password, ...], ...]
     */
    function getDataAllUsers(): ?array
    {
        $this->getAllDataFromDatabase(Paths::DIR_BASE_USERS);

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
        return $userInfo ?? null;
    }

    /**
     * Добавление пользователя
     */
    function addUser(User $user): void
    {
        if (empty($this->getLastId(Paths::DIR_BASE_USERS))) {
            $userId = 1;
        } else {
            $userId = ($this->getLastId(Paths::DIR_BASE_USERS) + 1);
        }
        $this->writingDatabase($user, Paths::DIR_BASE_USERS, $userId);
    }

    /**
     * Редактирование пользователя
     *
     * провера на существования пользователя с переданным id
     */
    function editUser(User $user, int $id): void
    {
        if ($this->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
            $this->writingDatabase($user, Paths::DIR_BASE_USERS, $id);
        }
    }

    /**
     * Записывает переданные данные в базу данных
     */
    function writingDatabase(User $user, string $database, int $id): void
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
        } finally {
            fclose($files);
        }
    }
}