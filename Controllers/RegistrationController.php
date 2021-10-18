<?php

namespace Controllers;

use Core\Middleware;
use Core\Validation;

class RegistrationController extends Middleware
{
    function get()
    {
        include_once "../views/registration-user.html.php";
    }

    function post()
    {
        $obj = new Validation();
        $info = $obj->mainForm($_POST['login'], $_POST['password'], $_POST['passwordConfirm'], $_POST['email'],
            $_POST['fullName'], $_POST['date'], $_POST['about']);
        include_once "../views/registration-user.html.php";
    }
}