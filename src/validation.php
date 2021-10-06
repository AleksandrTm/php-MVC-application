<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    return validation($login, $password);
} else {
    return null;
}

function validation($login, $password): string
{
    if (!empty($login) and !empty($password)) {
        return "
        <font color='green'>Регистрация успешна</font><br>
        Login: $login<br>
        Пароль: $password<br>
        ";
    } else {
        return "Ошибка валидации";
    }
}