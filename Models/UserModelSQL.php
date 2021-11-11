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


class UserModelSQL extends Model implements UserInterface
{
    /**
     * Отдаёт многомерный массив со всеми пользователями и данными
     * [idUser => ['login' => $login, 'password' => $password, ...], ...]
     */
    public function getDataUsers(): array
    {
        $userInfo = [];

        $pagination = new Pagination(db::USERS);

        $this->resultQuery = $this->mysqlConnect->query("SELECT * FROM users ORDER BY user_id LIMIT " .
            $this->appConfig['number_record_page'] . " OFFSET $pagination->beginWith");

        while ($user = $this->resultQuery->fetch_assoc()) {
            $userInfo[$user['user_id']] = [
                'login' => $user['login'],
                'password' => $user['password'],
                'email' => $user['email'],
                'fullName' => $user['full_name'],
                'date' => $user['date'],
                'about' => $user['about'],
                'role' => $user['role']
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
            $result = $this->mysqlConnect->query("SELECT * FROM users WHERE user_id = $id");
            while ($user = $result->fetch_assoc()) {
                $object->setRole($user['role']);
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
        try {
            return $this->mysqlConnect->query("SELECT user_id, login, password, full_name, role FROM users WHERE login = '$login'")->fetch_assoc();
        } catch (Throwable $t) {
            return null;
        }
    }

    /**
     * Получаем данные о пользователе по логину
     */
    public function getDataUser(int $id): ?array
    {
        try {
            return $this->mysqlConnect->query("SELECT * FROM users WHERE user_id = '$id'")->fetch_assoc();
        } catch (Throwable $t) {
            return null;
        }
    }

    /**
     * Добавление пользователя
     */
    public function addUser(User $user): bool
    {
        return $this->writingDatabase($user);
    }

    /**
     * Редактирование пользователя
     *
     * провера на существования пользователя с переданным id
     */
    public function editUser(User $user, int $id): void
    {
        $login = $user->getLogin();
        $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $email = $user->getEmail();
        $fullName = $user->getFullName();
        $date = $user->getDate();
        $about = $user->getAbout();

        $this->mysqlConnect->query("
                UPDATE users 
                SET login = '$login', password ='$password', email = '$email', full_name = '$fullName', date = '$date', about = '$about'
                WHERE user_id = '$id'");
    }

    /**
     * Записывает переданные данные в базу данных
     */
    public function writingDatabase(User $user, int $id = null, string $database = null, string $update = null): bool
    {
        $login = $user->getLogin();
        $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $email = $user->getEmail();
        $fullName = $user->getFullName();
        $date = $user->getDate();
        $about = $user->getAbout();

        try {
            $this->writeToDatabase("INSERT INTO users (login, password, email, full_name, date, about)
                                        VALUES ('$login', '$password', '$email', '$fullName', '$date', '$about')");
        } catch (Throwable $t) {
            if ($this->appConfig['debug'] === true) {
                var_dump($t);
            }

            return false;
        }

        return true;
    }
}