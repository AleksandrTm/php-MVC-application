<?php

namespace Controllers;

use Core\Middleware;
use Core\Validation;

class AddUsesController extends Middleware
{
    function get()
    {
        if (!$this->adminRules()) {
            $info = "нет прав, требуются права Администратора";
        } else {
            $info = include_once "../views/temp/form-add-user.html.php";
        }
        include_once "../views/add-user.html.php";
    }

    function post()
    {
        if (!$this->adminRules()) {
            $info = "нет прав, требуются права Администратора";
        } else {
            $obj = new Validation();
            $info = $obj->mainForm($_POST['login'], $_POST['password'], $_POST['passwordConfirm'], $_POST['email'],
                $_POST['fullName'], $_POST['date'], $_POST['about']);
        }

        include_once "../views/add-user.html.php";
    }
}