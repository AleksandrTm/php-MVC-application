<?php

class Valid
{
    function init()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return validation($_POST['type-form']);
        } else {
            return null;
        }
    }

    function validation($typeForm)
        /*
         *  Определяем кокой тип формы получен для дальнейшей обработки и валидации
         */
    {
        switch ($typeForm) {
            case "login":
                return valid_login();
            case "registration":
                return valid_registration();
            case "editUser":
                return valid_edit_user();
            case "add-user":
                return valid_add_user();
        }
    }

    function valid_login(): string
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        return $login . " : " . $password;
    }

    function valid_add_user()
    {

    }

    function valid_edit_user()
    {

    }

    function valid_registration()
    {

    }
}