<?php

namespace Core;

use Models\UserModel;

class Authorization
{
    /**
     * User данные полученные из $_POST
     * UserModel данные из Базы данных
     */
    function logInUser(User $user, UserModel $userModel): bool
    {
        /** Получаем все данные, всех пользователей из БД */
        $usersData = $userModel->getDataAllUsers();

        foreach ($usersData as $userData) {
            if ($userData['login'] === $user->getLogin() && password_verify($user->getPassword(), $userData['password'])) {
                $_SESSION['login'] = $user->getLogin();
                $_SESSION['role'] = $userData['role'];
                return true;
            }
        }
        return false;
    }

    function logOut(): void
    {
        session_destroy();
        header('Location: http://localsite.ru');
        exit;
    }
}