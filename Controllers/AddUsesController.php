<?php

namespace Controllers;

use Core\Middleware;
use Core\Validation;

class AddUsesController extends Middleware
{
    function get()
    {
        $info = include_once "../views/temp/form-add-user.html.php";
        include_once "../views/add-user.html.php";
    }

    function post()
    {
        $obj = new Validation();

        /**
         *
         *  В КОНТРОЛЛЕРЕ ВЫЗЫВАТЬ ВАЛИДАЦИЮ И ПОЛУЧАТЬ ОТВЕТ ( НИКАКИЕ ПАРАМЕТРЫ ТУТ НЕ ПЕРЕДАЕМ )
         *  С МОДЕЛЬЮ РАБОТАЕМ В КОНТРОЛЛЕРЕ А НЕ ВАЛИДАЦИИ
         *
         */
        $info = $obj->mainForm($_POST['login'], $_POST['password'], $_POST['passwordConfirm'], $_POST['email'],
            $_POST['fullName'], $_POST['date'], $_POST['about']);



        include_once "../views/add-user.html.php";
    }
}