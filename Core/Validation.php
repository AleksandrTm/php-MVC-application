<?php

namespace Core;


/**
 * Валидация форм и полей
 *
 * Возвращает String с ошибками или null при их отсутсвии
 */
class Validation
{
    protected string $login, $password, $passwordConfirm, $email, $fullName, $date, $about;

    public function __construct()
    {
        $this->login = htmlspecialchars($_POST['login']);
        $this->password = htmlspecialchars($_POST['password']);
        $this->passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);
        $this->email = htmlspecialchars($_POST['email']);
        $this->fullName = htmlspecialchars($_POST['fullName']);
        $this->date = htmlspecialchars($_POST['date']);
        $this->about = htmlspecialchars($_POST['about']);
    }

    function validation(): ?string
    {
        ob_start(); // Включение буферизации вывода

        $this->fieldLogin($this->login);
        $this->fieldPassword($this->password);
        $this->fieldEmail($this->email);
        $this->fieldFullName($this->fullName);
        $this->fieldDate($this->date);
        $this->fieldAbout($this->about);

        $bufferError = ob_get_contents(); // Сохраняем поток вывода

        ob_end_clean(); // Очищаем и закрываем буферизацию вывода

        return !empty($bufferError) ?: null; // отдаём буфер с ошибками или null
    }

    /**
     * Валидация input=date
     * с использованием:
     * explode() для разбития строки
     * checkdate() проверки корректности даты
     */
    function fieldDate($date): ?string
    {
        $dataYMD = explode("-", $date);
        if (!(checkdate($dataYMD[2], $dataYMD[1], $dataYMD[0])) and !(gettype($date) == "string")) {
            echo "- Дата не корректная <br>";
        }

        if (!($dataYMD[0] - date('Y') < 18)) {
            echo "- Пользователь должен быть старше 18 лет <br>";
        }

        return null;
    }

    /**
     * Валидация input=fullName
     * с использованием preg_match()
     */
    function fieldFullName($fullName): ?string
    {
        if (!(preg_match("/[А-Яа-яЁё ]/im", $fullName))) {
            echo "- Укажите корректно ФИО <br>";
        }
        return null;
    }

    /**
     * Валидация input=login
     * с использованием preg_match()
     */
    function fieldLogin($login): ?string
    {
        if (empty($login)) {
            echo "- Поле логин не может быть пустым <br>";
        }
        if (!(preg_match("/^.{5,16}$/", $login))) {
            echo "- Логин должен содержать от 5 до 16 латинских символов <br>";
        }
        if (!(preg_match("/^[a-zA-Z]{5,16}$/", $login))) {
            echo "- Логин должен содержать только латинские символы <br>";
        }
        return null;
    }

    /**
     * Валидация input=password
     * с использованием preg_match()
     */
    function fieldPassword($password): ?string
    {
        if (empty($password)) {
            echo "- Поле пароль не может быть пустым <br>";
        }
        if (!(preg_match("/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,30}$/", $password))) {
            echo "- Пароль должен содержать хотя бы одну цифру, одну строчную,
        одну заглавную латинскую букву, а так же один из символов: '@#$%!*',
        Длинна пароля от 8 до 30 символов <br>";
        }
        if (!(preg_match("/^[a-zA-Z0-9!@#$&*]{8,30}$/", $password))) {
            echo "- В пароле разрешены только латинские символы <br>";
        }
        return null;
    }

    /**
     * Валидация input=email
     * с использованием filter_var()
     */
    function fieldEmail($email): ?string
    {
        if (empty($email)) {
            echo "- Поле e-mail не может быть пустым <br>";
        }
        $check = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$check) {
            echo "- Не корректный email <br>";
        }
        return null;
    }

    /**
     * Валидация input=about
     * с использованием preg_match()
     */
    function fieldAbout($about): ?string
    {
        if (!(preg_match("/[а-яА-Яa-zA-Z0-9 ]{0,200}/", $about))) {
            echo "- Описание не может быть более 200 символов <br>";
        }
        return null;
    }
}