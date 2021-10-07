<?php

$match_field_login = "";
$match_field_pass = "";
$match_field_about = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    return validation($_POST['type-form']);
} else {
    return null;
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
        default:
            return "ошибка получения формы";
    }
}

function valid_login(): string
{
    $login = $_POST['login'];
    $password = $_POST['password'];

    $check_login = field_login($login);
    $check_pass = field_password($password);

    if (!($check_login === true)) {
        return $check_login;
    }
    if (!($check_pass === true)) {
        return $check_pass;
    }

    return "
        <div class='accept-reg'>Вы успешно зашли</div><br>
        Login: $login<br>
        Пароль: $password<br>
        ";

}

function valid_registration()
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password_с = $_POST['password-с'];
    $email = $_POST['email'];

    $check_login = field_login($login);
    $check_pass = field_password($password);
    $check_email = field_email($email);

    if (!($check_login === true)) {
        return $check_login;
    }
    if (!($check_pass === true)) {
        return $check_pass;
    }
    if (!($password_с == $password)) {
        return "Пароли должны совпадать";
    }
    if (!($check_email === true)) {
        return $check_email;
    }

    return "
        <div class='accept-reg'>Регистрация успешна</div><br>
        Login: $login<br>
        Пароль: $password<br>
        почта: $email<br>
        ";
}

function valid_add_user()
{

}

function valid_edit_user()
{

}

function field_login($login)
{
    if (empty($login)) {
        return "Поле логин не может быть пустым";
    } elseif (strlen($login) < 5) {
        return "Логин должен содержать 5 и более латинских символов";
    }
    return true;
}

function field_password($password)
{
    if (empty($password)) {
        return "Поле пароль не может быть пустым";
    } elseif (strlen($password) < 8) {
        return "Пароль должен содержать 8 и более латинских символов и цифр";
    }
    return true;
}

function field_email($email)
{
    $check = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$check) {
        return "Не корректный email";
    }
    return $check;
}