<?php

namespace Core;

use Models\Users;

/**
 * Валидатор для форм
 */
class Validation extends ValidatorField
{
    function mainForm($login, $password, $passwordConfirm, $email, $fullName, $date, $about, $id = null): string
    {
        $objUsers = new Users();

        $errorStatus = false;

        $checkLogin = parent::fieldLogin($login);
        $checkPass = parent::fieldPassword($password);
        $checkEmail = parent::fieldEmail($email);
        $checkFullName = parent::fieldFullName($fullName);
        $checkDate = parent::fieldDate($date);
        $checkAbout = parent::fieldAbout($about);

        ob_start(); // старт буфера вывода

        if (!($checkLogin === true)) {
            echo $checkLogin . "<br>";
            $errorStatus = true;
        }
        if (!($checkPass === true)) {
            echo $checkPass . "<br>";
            $errorStatus = true;
        }
        if (!($passwordConfirm == $password)) {
            echo "- Пароли должны совпадать <br>";
            $errorStatus = true;
        }
        if (!($checkEmail === true)) {
            echo $checkEmail . "<br>";
            $errorStatus = true;
        }
        if (!($checkDate === true)) {
            echo $checkDate . "<br>";
            $errorStatus = true;
        }
        if (!($checkFullName === true)) {
            echo $checkFullName . "<br>";
            $errorStatus = true;
        }
        if (!($checkAbout === true)) {
            echo $checkAbout . "<br>";
            $errorStatus = true;
        }

        $bufferError = ob_get_contents();
        ob_end_clean(); // очищаем и закрываем буфер

        if ($errorStatus) {
            return $bufferError;
        }

        if (is_null($id)) {
            $objUsers->add($login, $password, $email, $fullName, $date, $about);
            return "
        <div class='accept-reg'>Пользователь добален</div><br>
        Логин: $login<br>
        Пароль: $password<br>
        Почта: $email<br>
        ФИО: $fullName<br>
        Дата: $date<br>
        Описание: $about<br>
        ";
        } else {
            $objUsers->edit($id, $login, $password, $email, $fullName, $date, $about);
            return "
        <div class='accept-reg'>Изминения сохранены</div><br>
        Логин: $login<br>
        Пароль: $password<br>
        Почта: $email<br>
        ФИО: $fullName<br>
        Дата: $date<br>
        Описание: $about<br>
        ";
        }
    }
}