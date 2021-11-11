<?php

namespace Controllers;

use Core\Model;
use Entities\User;
use Core\Controller;
use Core\Validations;
use Enums\Database as db;
use Models\UserModel;
use Models\UserModelSQL;

class RegistrationController extends Controller
{
    private Model $model;

    public function __construct()
    {
        parent::__construct();
        if ($this->appConfig['database'] === db::MYSQL) {
            $this->model = new UserModelSQL();
        } else {
            $this->model = new UserModel();
        }
    }

    public function getRegistrationForm(): void
    {
        $this->view->render('registration', 'Регистрация');
    }

    public function getResultRegistrationUser(): void
    {
        $user = new User();
        $objValidation = new Validations();

        $info = $objValidation->validatesForms($user);

        if (isset($info)) {
            $info[] = 'Ошибка регистрации';
        } else {
            $info = ['Регистрация успешна'];
            $status = $this->model->addUser($user);

            if(!$status) {
                $info = [];
                $info[] = "ошибка подключения к таблице";
            }
        }
        $this->view->render('registration','Регистрация', $info);
    }
}