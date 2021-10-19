<?php

namespace Controllers;

use Core\Controller;
use Core\Middleware;
use Core\Validation;
use Models\Users;

class EditUsersController extends Controller
{
    function get($id)
    {
        if ((new Users())->findUser($id)) {
            include_once "../views/edit-user.html.php";
        } else {
            header('Location: http://localsite.ru');
            exit();
        }
    }

    function post($id)
    {
        $obj = new Validation();
        $info = $obj->mainForm($_POST['login'], $_POST['password'], $_POST['passwordConfirm'], $_POST['email'],
            $_POST['fullName'], $_POST['date'], $_POST['about'], $id);
        include_once "../views/edit-user.html.php";
    }
}