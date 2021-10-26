<?php

namespace Controllers;

use Entities\User;
use Core\Controller;
use Core\Authorization;
use Models\UserModel;

/**
 * Контроллер Сессии пользователя ( авторизация, выход )
 */
class LoginController extends Controller
{
    protected Authorization $authorization;
    protected bool $authorizationStatus;

    public function __construct()
    {
        parent::__construct();
        $this->authorization = new Authorization();
    }

    /**
     * Получаем форму для авторизации ( ввода логина и пароля )
     */
    function getLoginForm(): void
    {
        $this->view->render("login", 'Авторизация');
    }

    /**
     * Результат авторизации ( набор ошибок или успех авторизации )
     */
    function getResultAuthorizationUser(): void
    {
        $objUserModel = new UserModel();
        $objUser = new User();

        $this->authorizationStatus = $this->authorization->logInUser($objUser, $objUserModel);

        $info = ['statusAuthorization' => $this->authorizationStatus];

        $this->view->render("login", 'Авторизация', $info);
    }

    /**
     * Вызов выхода из авторизации ( выход для пользователя )
     */
    function logsOut(): void
    {
        $this->authorization->logOut();
    }
}