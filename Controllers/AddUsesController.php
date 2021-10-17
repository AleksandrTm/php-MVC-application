<?php

namespace Controllers;

use Core\Controller;
use Core\Validation;

class AddUsesController extends Controller
{
    public static ?string $info = null;

    function get()
    {
        include_once "../views/add-user.html.php";
    }

    function post()
    {
        $obj = new Validation();
        self::$info = $obj->mainForm($_POST['login'], $_POST['password'], $_POST['passwordConfirm'], $_POST['email'],
            $_POST['fullName'], $_POST['date'], $_POST['about']);
        include_once "../views/add-user.html.php";
    }
}