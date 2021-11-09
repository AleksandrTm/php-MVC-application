<?php

namespace Controllers;

use Entities\User;
use Core\Controller;
use Core\Validations;
use Models\UserModel;

class RegistrationController extends Controller
{
    public function getRegistrationForm(): void
    {
        $this->view->render('registration', 'Регистрация');
    }

    public function getResultRegistrationUser(): void
    {
        $user = new User();
        $objUsers = new UserModel();
        $objValidation = new Validations();

        $info = $objValidation->validatesForms($user);

        if (isset($info)) {
            $info[] = 'Ошибка регистрации';
        } else {
            $info = ['Регистрация успешна'];
            $status = $objUsers->addUser($user);

            if(!$status) {
                $info = [];
                $info[] = "ошибка подключения к таблице";
            }
        }
        $this->view->render('registration','Регистрация', $info);
    }
}