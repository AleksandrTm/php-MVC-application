<?php

use src\Model\Users;

const TEXT_PASSWORD_CONFIRM = "- Пароли должны совпадать";

// проверяем получен POST запрос или нет.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // передаем в валидатор форму
    return validation($_POST['type-form']);
}
// Нет ответа от POST, отдаем null.
return null;


/**
 *  Определяем кокой тип формы получен для дальнейшей валидации и обработки
 */
function validation($typeForm): string
{
    $login = array_key_exists('login', $_POST) ? $_POST['login'] : null;
    $password = array_key_exists('password', $_POST) ? $_POST['password'] : null;
    $passwordConfirm = array_key_exists('passwordConfirm', $_POST) ? $_POST['passwordConfirm'] : null;
    $email = array_key_exists('email', $_POST) ? $_POST['email'] : null;
    $fullName = array_key_exists('fullName', $_POST) ? $_POST['fullName'] : null;
    $date = array_key_exists('date', $_POST) ? $_POST['date'] : null;
    $about = array_key_exists('about', $_POST) ? $_POST['about'] : null;


    switch ($typeForm) {
        case "login":
            return validLogin($login, $password);
        case "registration":
        case "edit-user":
        case "add-user":
            return mainForm($login, $password, $passwordConfirm, $email, $fullName, $date, $about);
        default:
            return "ошибка получения формы";
    }
}

function mainForm($login, $password, $passwordConfirm, $email, $fullName, $date, $about)
{
    $check_login = fieldLogin($login);
    $check_pass = fieldPassword($password);
    $check_email = fieldEmail($email);
    $check_fullName = fieldFullName($fullName);
    $check_date = fieldDate($date);
    $check_about = fieldAbout($about);

    if (!($check_login === true)) {
        return $check_login;
    }
    if (!($check_pass === true)) {
        return $check_pass;
    }
    if (!($passwordConfirm == $password)) {
        return TEXT_PASSWORD_CONFIRM;
    }
    if (!($check_email === true)) {
        return $check_email;
    }
    if (!($check_date === true)) {
        return $check_date;
    }
    if (!($check_fullName === true)) {
        return $check_fullName;
    }
    if (!($check_about === true)) {
        return $check_about;
    }
    Users::addUser($login, $password, $email, $fullName, $date, $about);
    return "
        <div class='accept-reg'>Всё ок</div><br>
        Логин: $login<br>
        Пароль: $password<br>
        Почта: $email<br>
        ФИО: $fullName<br>
        Дата: $date<br>
        Описание: $about<br>
        ";

}

/**
 * Валидация входа на сайт
 */
function validLogin($login, $password): string
{
    $bufferError = "";
    $errorStatus = false;

    $checkLogin = fieldLogin($login);
    $checkPass = fieldPassword($password);

    if (!($checkLogin === true)) {
        $bufferError .= $checkLogin . "<br>";
        $errorStatus = true;
    }
    if (!($checkPass === true)) {
        $bufferError .= $checkPass . "<br>";
        $errorStatus = true;
    }

    if ($errorStatus) {
        return $bufferError;
    }
    return "
        <div class='accept-reg'>Вы успешно зашли на сайт</div><br>
        Login: $login<br>
        Пароль: $password<br>
        ";

}

/**
 * Валидация input=date
 * с использованием:
 * explode() для разбития строки
 * checkdate() проверки корректности даты
 */
function fieldDate($date)
{
    $dataYMD = explode("-", $date);
    if (!(checkdate($dataYMD[2], $dataYMD[1], $dataYMD[0])) and !(gettype($date) == "string")) {
        return "- Дата не корректная";
    }

    if (!($dataYMD[0] - date('Y') < 18)) {
        return "- Пользователь должен быть старше 18 лет";
    }

    return true;
}

function fieldFullName($fullName)
    /*
     * Валидация input=fullName
     * с использованием preg_match()
     */
{
    if (!(preg_match("/[А-Яа-яЁё ]/im", $fullName))) {
        return "- Укажите корректно ФИО";
    }
    return true;
}

/**
 * Валидация input=login
 * с использованием preg_match()
 */
function fieldLogin($login)
{
    if (empty($login)) {
        return "- Поле логин не может быть пустым";
    }
    if (!(preg_match("/^.{5,16}$/", $login))) {
        return "- Логин должен содержать от 5 до 16 латинских символов";
    }
    if (!(preg_match("/^[a-zA-Z]{5,16}$/", $login))) {
        return "- Логин должен содержать только латинские символы";
    }
    return true;
}

/**
 * Валидация input=password
 * с использованием preg_match()
 */
function fieldPassword($password)
{
    if (empty($password)) {
        return "- Поле пароль не может быть пустым";
    }
    if (!(preg_match("/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,30}$/", $password))) {
        return "- Пароль должен содержать хотя бы одну цифру, одну строчную,
        одну заглавную латинскую букву, а так же один из символов: '@#$%!*',
        Длинна пароля от 8 до 30 символов";
    }
    if (!(preg_match("/^[a-zA-Z0-9!@#$&*]{8,30}$/", $password))) {
        return "- В пароле разрешены только латинские символы";
    }
    return true;
}

/**
 * Валидация input=email
 * с использованием filter_var()
 */
function fieldEmail($email)
{
    if (empty($email)) {
        return "- Поле e-mail не может быть пустым";
    }
    $check = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$check) {
        return "- Не корректный email";
    }
    return true;
}

/**
 * Валидация input=about
 * с использованием preg_match()
 */
function fieldAbout($about)
{
    if (!(preg_match("/[а-яА-Яa-zA-Z0-9 ]{0,200}/", $about))) {
        return "- Описание не может быть более 200 символов";
    }
    return true;
}