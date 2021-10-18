<?php

namespace Core;


/**
 * Валидатор для полей
 * Каждая функция проверяет определенное поле по шаблону
 */
class ValidatorField
{
    protected bool $errorStatus = false;

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
            return "- Дата не корректная <br>";
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
}