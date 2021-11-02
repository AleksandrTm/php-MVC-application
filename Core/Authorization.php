<?php

namespace Core;

use Models\UserModel;
use Entities\User;

class Authorization
{
    /**
     * Сверяет полученные данные из формы, с данными в базе данных
     */
    public function logInUser(User $user, UserModel $userModel): bool
    {
        $usersData = $userModel->getDataUsers();

        if (!isset($usersData)) {
            return false;
        }
        foreach ($usersData as $key => $userData) {
            if ($userData['login'] === $user->getLogin() && password_verify($user->getPassword(), $userData['password'])) {
                $_SESSION['login'] = $user->getLogin();
                $_SESSION['role'] = $userData['role'];
                $_SESSION['id'] = $key;

                return true;
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
        session_start();

        header('Location: http://localsite.ru');
        exit;
    }
}