<?php
include_once "../src/File.php";

use Localsite\src\File;

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
    switch ($typeForm) {
        case "login":
            return validLogin();
        case "registration":
            return validRegistration();
        case "edit-user":
            return validEditUser();
        case "add-user":
            return validAddUser();
        default:
            return "ошибка получения формы";
    }
}

/**
 * Валидация входа на сайт
 */
function validLogin(): string
{
    $login = $_POST['login'];
    $password = $_POST['password'];

    $checkLogin = fieldLogin($login);
    $checkPass = fieldPassword($password);

    if (!($checkLogin === true)) {
        return $checkLogin;
    }
    if (!($checkPass === true)) {
        return $checkPass;
    }

    return "
        <div class='accept-reg'>Вы успешно зашли</div><br>
        Login: $login<br>
        Пароль: $password<br>
        ";

}

/**
 * Валидация регистрации нового пользователя
 */
function validRegistration(): string
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];

    $checkLogin = fieldLogin($login);
    $checkPass = fieldPassword($password);
    $checkEmail = fieldEmail($email);
    $check_fullName = fieldFullName($fullName);

    if (!($checkLogin === true)) {
        return $checkLogin;
    }
    if (!($checkPass === true)) {
        return $checkPass;
    }
    if (!($passwordConfirm == $password)) {
        return "Пароли должны совпадать";
    }
    if (!($checkEmail === true)) {
        return $checkEmail;
    }
    if (!($check_fullName === true)) {
        return $check_fullName;
    }

    return "
        <div class='accept-reg'>Регистрация успешна</div><br>
        Login: $login<br>
        Пароль: $password<br>
        почта: $email<br>
        ";
}

/**
 * Валидация добавление нового пользователя
 */
function validAddUser()
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $date = $_POST['date'];
    $about = $_POST['about'];

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
        return "Пароли должны совпадать";
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
    File::addUser($login, $password, $email, $fullName, $date, $about);
    return "
        <div class='accept-reg'>Пользователь успешно добавлен</div><br>
        Логин: $login<br>
        Пароль: $password<br>
        Почта: $email<br>
        ФИО: $fullName<br>
        Дата: $date<br>
        Описание: $about<br>
        ";

}

/**
 * Валидация редактирования пользователя
 */
function validEditUser()
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $date = $_POST['date'];
    $about = $_POST['about'];

    $checkLogin = fieldLogin($login);
    $checkPass = fieldPassword($password);
    $checkEmail = fieldEmail($email);
    $checkFullName = fieldFullName($fullName);
    $checkDate = fieldDate($date);
    $checkAbout = fieldAbout($about);

    if (!($checkLogin === true)) {
        return $checkLogin;
    }
    if (!($checkPass === true)) {
        return $checkPass;
    }
    if (!($passwordConfirm == $password)) {
        return "Пароли должны совпадать";
    }
    if (!($checkEmail === true)) {
        return $checkEmail;
    }
    if (!($checkDate === true)) {
        return $checkDate;
    }
    if (!($checkFullName === true)) {
        return $checkFullName;
    }
    if (!($checkAbout === true)) {
        return $checkAbout;
    }

    return "
        <div class='accept-reg'>Редактирование успешно</div><br>
        Логин: $login<br>
        Пароль: $password<br>
        Почта: $email<br>
        ФИО: $fullName<br>
        Дата: $date<br>
        Описание: $about<br>
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
        return "Дата не корректная";
    }

    if (!($dataYMD[0] - date('Y') < 18)) {
        return "Пользователь должен быть старше 18 лет";
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
        return "Укажите корректно ФИО";
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
        return "Поле логин не может быть пустым";
    }
    if (!(preg_match("/^.{5,16}$/", $login))) {
        return "Логин должен содержать от 5 до 16 латинских символов";
    }
    if (!(preg_match("/^[a-zA-Z]{5,16}$/", $login))) {
        return "Логин должен содержать только латинские символы";
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
        return "Поле пароль не может быть пустым";
    }
    if (!(preg_match("/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,30}$/", $password))) {
        return "Пароль должен содержать хотя бы одну цифру, одну строчную,
        одну заглавную латинскую букву, а так же один из символов: '@#$%!*',
        Длинна пароля от 8 до 30 символов";
    }
    if (!(preg_match("/^[a-zA-Z0-9!@#$&*]{8,30}$/", $password))) {
        return "В пароле разрешены только латинские символы";
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
        return "Поле e-mail не может быть пустым";
    }
    $check = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$check) {
        return "Не корректный email";
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
        return "Описание не может быть более 200 символов";
    }
    return true;
}