<?php

namespace Controllers;

use Core\Controller;
use Core\Validation;

class EditUsersController extends Controller
{
    public static ?string $info = null;

    function get()
    {
        include_once "../views/edit-user.html.php";
    }

    function post($urlId)
    {
        $id = preg_replace("/[^,.0-9]/", '', $urlId);
        $obj = new Validation();
        self::$info = $obj->mainForm($_POST['login'], $_POST['password'], $_POST['passwordConfirm'], $_POST['email'],
            $_POST['fullName'], $_POST['date'], $_POST['about'], $id);
        include_once "../views/edit-user.html.php";
    }
}