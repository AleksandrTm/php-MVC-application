<?php

namespace Controllers;

use Core\Model;
use Entities\User;
use Core\Controller;
use Core\Authorization;
use Enums\Database as db;
use Models\UserModel;
use Models\UserModelSQL;

/**
 * Контроллер Сессии пользователя ( авторизация, выход )
 */
class LoginController extends Controller
{
    protected Authorization $authorization;
    protected bool $authorizationStatus;
    private Model $model;

    public function __construct()
    {
        parent::__construct();
        $this->authorization = new Authorization();
        if ($this->appConfig['database'] === db::MYSQL) {
            $this->model = new UserModelSQL();
        } else {
            $this->model = new UserModel();
        }
    }

    /**
     * Получаем форму для авторизации ( ввода логина и пароля )
     */
    public function getLoginForm(): void
    {
        $this->view->render("login", 'Авторизация');
    }

    /**
     * Результат авторизации ( набор ошибок или успех авторизации )
     */
    public function getResultAuthorizationUser(): void
    {
        $objUser = new User();

        $this->authorizationStatus = $this->authorization->logInUser($objUser, $this->model);

        $info = ['statusAuthorization' => $this->authorizationStatus];

        $this->view->render("login", 'Авторизация', $info);
    }

    /**
     * Вызов выхода из авторизации ( выход для пользователя )
     */
    public function logsOut(): void
    {
        $this->authorization->logOut();
    }
}