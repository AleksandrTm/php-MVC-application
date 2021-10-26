<?php

namespace Core;

use Models\UserModel;
use Entities\User;

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

        /** Проверка переданных в POST запросе данных с данным в базе данных */
        foreach ($usersData as $userData) {
            if ($userData['login'] === $user->getLogin() && password_verify($user->getPassword(), $userData['password'])) {
                $_SESSION['login'] = $user->getLogin();
                $_SESSION['role'] = $userData['role'];
                return true;
            }
        }
        return false;
    }

    /**
     * Убивает сессию пользователя, тем самым выходит из текущей авторизации
     */
    function logOut(): void
    {
        /** Убиваем данные сессии */
        session_destroy();

        header('Location: http://localsite.ru');
        exit;
    }
}