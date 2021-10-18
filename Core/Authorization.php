<?php

namespace Core;

use Models\Users;

class Authorization
{
    function authentication()
    {
        $users = new Users();
        $dataUsers = $users->userLoginPassword();
        $userLogin = htmlspecialchars($_POST['login']);
        $userPassword = htmlspecialchars($_POST['password']);

        foreach ($dataUsers as $user) {
            if ($user['login'] === $userLogin and !password_verify($user['password'], $userPassword)) {
                $_SESSION['login'] = $userLogin;
                $_SESSION['password'] = $user['password'];
                $_SESSION['role'] = $user['role'];
            }
        }
    }

    function out()
    {
        session_destroy();
        header('Location: http://localsite.ru');
        exit;
    }
}