<?php

namespace Controllers;

use Core\Controller;
use Core\Validation;

class RegistrationController extends Controller
{
    public ?string $info = null;

    function get()
    {
        include_once "../views/registration-user.html.php";
    }

    function post()
    {
        $obj = new Validation();
        $this->info = $obj->mainForm($_POST['login'], $_POST['password'], $_POST['passwordConfirm'], $_POST['email'],
            $_POST['fullName'], $_POST['date'], $_POST['about']);
        include_once "../views/registration-user.html.php";
    }
}