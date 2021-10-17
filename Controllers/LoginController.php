<?php

namespace Controllers;

use Core\Controller;
use Core\Validation;


class LoginController extends Controller
{
    public static ?string $info = null;

    public function get()
    {
        include_once "../views/login.html.php";
    }

    function post()
    {
        $obj = new Validation();
        self::$info = $obj->validLogin($_POST['login'], $_POST['password']);
        include_once "../views/login.html.php";
    }
}