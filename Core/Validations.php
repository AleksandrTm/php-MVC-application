<?php

namespace Core;

use Entities\Content;
use Entities\User;

/**
 * Возвращает массив с ошибками или true при их отсутсвии ( успешной валидации )
 */
class Validations
{
    protected ?array $validationErrors = null;

    /**
     * Вызывает функции проверки для полей пользователя, валидирует форму
     */
    public function validatesForms(User $user): ?array
    {
        $this->checksLoginField($user->getLogin());
        $this->checksPasswordField($user->getPassword());
        $this->checksPasswordConfirm($user->getPassword(), $user->getPasswordConfirm());
        $this->checksEmailField($user->getEmail());
        $this->checksFullNameField($user->getFullName());
        $this->checksDateField($user->getDate());
        $this->checksAboutField($user->getAbout());

        return $this->validationErrors;
    }

    /**
     * Вызывает функции проверки для полей контента, валидирует форму
     */
    public function validatesFormsContent(Content $content): ?array
    {
        $this->checksTitleField($content->getTitle());
        $this->checksTextField($content->getText());

        return $this->validationErrors;
    }

    /**
     * Проверка на совпадение паролей
     */
    protected function checksPasswordConfirm(string $password, string $passwordConfirm): void
    {
        if (!($password === $passwordConfirm)) {
            $this->validationErrors[] = "- Пароли не совпадают";
        }
    }

    /**
     * Валидация input=date
     * с использованием:
     * explode() для разбития строки
     * checkdate() проверки корректности даты
     */
    protected function checksDateField(string $date): void
    {
        $dataYMD = explode("-", $date);
        if (!(checkdate($dataYMD[2], $dataYMD[1], $dataYMD[0])) && !(gettype($date) == "string")) {
            $this->validationErrors[] = "- Дата не корректная";
        }

        if (!($dataYMD[0] - date('Y') < 18)) {
            $this->validationErrors[] = "- Пользователь должен быть старше 18 лет";
        }
    }

    /**
     * Валидация input=fullName
     * с использованием preg_match()
     */
    protected function checksFullNameField(string $fullName): void
    {
        if (!(preg_match("/[А-Яа-яЁё ]/im", $fullName))) {
            $this->validationErrors[] = "- Укажите корректно ФИО";
        }
    }

    /**
     * Валидация input=login
     * с использованием preg_match()
     */
    protected function checksLoginField(string $login): void
    {
        if (empty($login)) {
            $this->validationErrors[] = "- Поле логин не может быть пустым";
        }
        if (!(preg_match("/^.{5,16}$/", $login))) {
            $this->validationErrors[] = "- Логин должен содержать от 5 до 16 латинских символов";
        }
        if (!(preg_match("/^[a-zA-Z]{5,16}$/", $login))) {
            $this->validationErrors[] = "- Логин должен содержать только латинские символы";
        }
    }

    /**
     * Валидация input=password
     * с использованием preg_match()
     */
    protected function checksPasswordField(string $password): void
    {
        if (empty($password)) {
            $this->validationErrors[] = "- Поле пароль не может быть пустым";
        }
        if (!(preg_match("/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,30}$/", $password))) {
            $this->validationErrors[] = "- Пароль должен содержать хотя бы одну цифру, одну строчную,
        одну заглавную латинскую букву, а так же один из символов: '@#$%!*',
        Длинна пароля от 8 до 30 символов";
        }
        if (!(preg_match("/^[a-zA-Z0-9!@#$&*]{8,30}$/", $password))) {
            $this->validationErrors[] = "- В пароле разрешены только латинские символы";
        }
    }

    /**
     * Валидация input=email
     * с использованием filter_var()
     */
    protected function checksEmailField(string $email): void
    {
        if (empty($email)) {
            $this->validationErrors[] = "- Поле e-mail не может быть пустым";
        }
        $check = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$check) {
            $this->validationErrors[] = "- Не корректный email";
        }
    }

    /**
     * Валидация input=about
     * с использованием preg_match()
     */
    protected function checksAboutField(string $about): void
    {
        if (!(preg_match("/^[а-яА-Яa-zA-Z0-9 ]{0,200}$/", $about))) {
            $this->validationErrors[] = "- Описание не может быть более 200 символов";
        }
    }

    /**
     * Проверка поля Заголовок контента
     */
    protected function checksTitleField(string $getTitle): void
    {
        if (!(preg_match("/[a-zA-Zа-яА-Я ]{0,50}/", $getTitle))) {
            $this->validationErrors[] = "- Поле заголовок не может быть пустым";
        }
    }

    /**
     * Проверка поля текст контента
     */
    protected function checksTextField(string $getText): void
    {
        if (!(preg_match("/[a-zA-Zа-яА-Я ]{0,200}/", $getText))) {
            $this->validationErrors[] = "- Поле текст не может быть пустым";
        }
    }
}