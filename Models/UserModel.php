<?php

namespace Models;

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
    public function getDataUsers(): array
    {
        $userInfo = [];

        $this->getRecordsFromDatabase(db::USERS, $this->appConfig['number_record_page']);

        if ($this->appConfig['database'] === db::MYSQL) {
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
        }
        if ($this->appConfig['database'] === db::FILES) {
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
     * Получаем данные о пользователе по логину
     */
    public function getDataForAuthorization(string $login): array
    {
        return $this->mysqlConnect->query("SELECT user_id, login, password, role FROM users WHERE login = '$login'")->fetch_assoc();
    }

    /**
     * Добавление пользователя
     */
    public function addUser(User $user): void
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            $this->writingDatabase($user);
        }
        if ($this->appConfig['database'] === db::FILES) {
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
        if ($this->appConfig['database'] === db::MYSQL) {
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

        if ($this->appConfig['database'] === db::FILES) {
            if ($this->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
                $this->writingDatabase($user, $id, Paths::DIR_BASE_USERS);
            }
        }
    }

    /**
     * Записывает переданные данные в базу данных
     */
    public function writingDatabase(User $user, int $id = null, string $database = null, string $update = null): void
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            $login = $user->getLogin();
            $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $email = $user->getEmail();
            $fullName = $user->getFullName();
            $date = $user->getDate();
            $about = $user->getAbout();


            $this->writeToDatabase("INSERT INTO users (login, password, email, full_name, date, about)
                                        VALUES ('$login', '$password', '$email', '$fullName', '$date', '$about')");

        }
        if ($this->appConfig['database'] === db::FILES) {
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