<?php

namespace Core;

use Models\Users;

/**
 * Валидатор для форм
 */
class ValidatorForm extends ValidatorField
{
    function mainForm($login, $password, $passwordConfirm, $email, $fullName, $date, $about, $id = null): string
    {
        $bufferError = "";
        $errorStatus = false;

        $checkLogin = parent::fieldLogin($login);
        $checkPass = parent::fieldPassword($password);
        $checkEmail = parent::fieldEmail($email);
        $checkFullName = parent::fieldFullName($fullName);
        $checkDate = parent::fieldDate($date);
        $checkAbout = parent::fieldAbout($about);

        if (!($checkLogin === true)) {
            $bufferError .= $checkLogin . "<br>";
            $errorStatus = true;
        }
        if (!($checkPass === true)) {
            $bufferError .= $checkPass . "<br>";
            $errorStatus = true;
        }
        if (!($passwordConfirm == $password)) {
            $bufferError .= "- Пароли должны совпадать <br>";
            $errorStatus = true;
        }
        if (!($checkEmail === true)) {
            $bufferError .= $checkEmail . "<br>";
            $errorStatus = true;
        }
        if (!($checkDate === true)) {
            $bufferError .= $checkDate . "<br>";
            $errorStatus = true;
        }
        if (!($checkFullName === true)) {
            $bufferError .= $checkFullName . "<br>";
            $errorStatus = true;
        }
        if (!($checkAbout === true)) {
            $bufferError .= $checkAbout . "<br>";
            $errorStatus = true;
        }
        if ($errorStatus) {
            return $bufferError;
        }
        if (is_null($id)) {
            var_dump("TEST1");
            Users::add($login, $password, $email, $fullName, $date, $about);
        } else {
            var_dump("TEST2");
            Users::edit($id, $login, $password, $email, $fullName, $date, $about);
        }
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

        $checkLogin = ValidatorField::fieldLogin($login);
        $checkPass = ValidatorField::fieldPassword($password);

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
}