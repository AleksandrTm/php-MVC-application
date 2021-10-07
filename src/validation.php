<?php
/*
 *  Временная функциональная реализация
 *  Объектная хранится в файле Valid.php
 */

// проверяем получен POST запрос или нет.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // передаем в валидатор форму
    return validation($_POST['type-form']);
}
// Нет ответа от POST, ничего не отдаем.
return null;


function validation($typeForm)
    /*
     *  Определяем кокой тип формы получен для дальнейшей валидации и обработки
     */
{
    switch ($typeForm) {
        case "login":
            return valid_login();
        case "registration":
            return valid_registration();
        case "edit-user":
            return valid_edit_user();
        case "add-user":
            return valid_add_user();
        default:
            return "ошибка получения формы";
    }
}

function valid_login(): string
    /*
     * Валидация входа на сайт
     */
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
    /*
     * Валидация регистрации нового пользователя
     */
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
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
    if (!($passwordConfirm == $password)) {
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
    /*
     * Валидация регистрации нового пользователя
     */
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $date = $_POST['date'];
    $about = $_POST['about'];

    $check_login = field_login($login);
    $check_pass = field_password($password);
    $check_email = field_email($email);
    $check_fullName = field_fullName($fullName);
    $check_about = field_about($email);

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

    return "
        <div class='accept-reg'>Редактирование успешно</div><br>
        Логин: $login<br>
        Пароль: $password<br>
        Почта: $email<br>
        Дата: $date<br>
        Описание: $about<br>
        ";
}

function field_fullName($about)
    /*
     * Валидация input=about
     * с использованием preg_match()
     */
{
    if (!(preg_match("/^([а-яА-Я]{1,20})([ ]{1})([а-яА-Я]{1,20})([ ]{0,1})$/", $about))) {
        return "Укажите корректно ФИО";
    }
    return true;
}

function field_login($login)
    /*
     * Валидация input=login
     * с использованием preg_match()
     */
{
    if ((empty($login))) {
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

function field_password($password)
    /*
     * Валидация input=password
     * с использованием preg_match()
     */
{
    if (empty($password)) {
        return "Поле пароль не может быть пустым";
    }
    if (!(preg_match("/^[a-zA-Z0-9_-]{8,16}$/", $password))) {
        return "Пароль должен содержать от 8 до 16 латинских символов, цифр и знаков - _";
    }
    if (!(preg_match("/^a-z{1,16}A-Z{1,16}0-9{1,16}$/", $password))) {
        return "Пароль должен содержать хотя бы одну цифру, одну строчную и одну заглавную латинскую букву";
    }
    return true;
}

function field_email($email)
    /*
     * Валидация input=email
     * с использованием filter_var()
     */
{
    $check = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$check) {
        return "Не корректный email";
    }
    return $check;
}

function field_about($about)
    /*
     * Валидация input=about
     * с использованием preg_match()
     */
{
    if (!(preg_match("/^.{0,200}$/", $about))) {
        return "Описание не может быть более 200 символов";
    }
    return true;
}