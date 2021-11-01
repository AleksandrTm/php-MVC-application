<?php

namespace Models;

use config\App;
use Enums\Database as db;
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
    public function getDataAllUsers(): array
    {
        $userInfo = [];
        if (App::DATABASE === db::MYSQL) {
            $this->getAllDataFromDatabase('SELECT * FROM users');

            while ($user = $this->resultQuery->fetch_assoc()) {
                $userInfo[$user['userId']] = [
                    'login' => $user['login'],
                    'password' => $user['password'],
                    'email' => $user['email'],
                    'fullName' => $user['fullName'],
                    'date' => $user['date'],
                    'about' => $user['about'],
                    'role' => $user['role']
                ];
            }
        } else {
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
        }
        return $userInfo;
    }

    /**
     * Добавление пользователя
     */
    public function addUser(User $user): void
    {
        if (App::DATABASE === db::MYSQL) {
            $this->writingDatabase($user);
        }
        if (App::DATABASE === db::FILES) {
            if (empty($this->getLastId(Paths::DIR_BASE_USERS))) {
                $userId = 1;
            } else {
                $userId = ($this->getLastId(Paths::DIR_BASE_USERS) + 1);
            }
            $this->writingDatabase($user, $userId, Paths::DIR_BASE_USERS);
        }
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
    public function writingDatabase(User $user, int $id = null, string $database = null): void
    {
        if (App::DATABASE === db::MYSQL) {
            $login = $user->getLogin();
            $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $email = $user->getEmail();
            $fullName = $user->getFullName();
            $date = $user->getDate();
            $about = $user->getAbout();

            $this->writeToDatabase("INSERT INTO users (login, password, email, fullName, date, about)
                                        VALUES ('$login', '$password', '$email', '$fullName', '$date', '$about')");

        }
        if (App::DATABASE === db::FILES) {
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
}