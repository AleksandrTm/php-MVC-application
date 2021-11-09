<?php

namespace Core;

use Enums\Database as db;
use Models\UserModel;
use Entities\User;

class Authorization
{

    /**
     * Сверяет полученные данные из формы, с данными в базе данных
     */
    public function logInUser(User $user, UserModel $userModel): bool
    {
        $appConfig = include "../config/app.php";

        if ($appConfig['database'] === db::MYSQL) {
            $usersData = $userModel->getDataForAuthorization($user->getLogin());

            if (!isset($usersData)) {
                return false;
            }
            if ($usersData['login'] === $user->getLogin() && password_verify($user->getPassword(), $usersData['password'])) {
                $_SESSION['login'] = $user->getLogin();
                $_SESSION['role'] = $usersData['role'];
                $_SESSION['fullName'] = $usersData['full_name'];
                $_SESSION['id'] = $usersData['user_id'];

                return true;
            }
        } else {
            $usersData = $userModel->getDataUsers();

            if (!isset($usersData)) {
                return false;
            }
            foreach ($usersData as $key => $userData) {
                if ($userData['login'] === $user->getLogin() && password_verify($user->getPassword(), $userData['password'])) {
                    $_SESSION['login'] = $user->getLogin();
                    $_SESSION['role'] = $userData['role'];
                    $_SESSION['fullName'] = $userData['fullName'];
                    $_SESSION['id'] = $key;

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Убивает сессию пользователя, тем самым выходит из текущей авторизации
     */
    public function logOut(): void
    {
        /** Убиваем данные сессии */
        session_destroy();

        header('Location: http://localsite.ru');
        exit;
    }
}