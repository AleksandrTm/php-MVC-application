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
            $userId = Paths::DIR_BASE_USERS . 1;
        } else {
            $userId = Paths::DIR_BASE_USERS . ($this->getLastId(Paths::DIR_BASE_USERS) + 1);
        }
        $this->writeData($user, $userId);
    }

    /**
     * Редактирование пользователя
     *
     * провера на существования пользователя с переданным id
     */
    function editUser(User $user, int $id): void
    {
        if ($this->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
            $this->writeData($user, Paths::DIR_BASE_USERS . $id);
        }
    }

    function writeData(User $user, $id): void
    {
        $files = null;
        try {
            $files = fopen($id, 'w');
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