<?php

namespace Controllers;

use Entities\User;
use Core\Controller;
use Core\Authorization;
use Models\UserModel;


class LoginController extends Controller
{
    protected Authorization $authorization;
    protected bool $authorizationStatus;

    public function __construct()
    {
        parent::__construct();
        $this->authorization = new Authorization();
    }

    public function getLoginForm(): void
    {
        $this->view->render("login", 'Авторизация');
    }

    function getResultAuthorizationUser(): void
    {
        $objUserModel = new UserModel();
        $objUser = new User();

        $this->authorizationStatus = $this->authorization->logInUser($objUser, $objUserModel);

        $info = ['statusAuthorization' => $this->authorizationStatus];

        $this->view->render("login", 'Авторизация', $info);
    }

    public function logsOut(): void
    {
        $this->authorization->logOut();
    }
}