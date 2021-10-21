<?php

namespace Controllers;

use Core\User;
use Core\Controller;
use Core\Validations;
use Models\UserModel;

class RegistrationController extends Controller
{
    function getRegistrationForm(): void
    {
        $this->view->render('registration', 'Регистрация');
    }

    function getResultRegistrationUser(): void
    {
        $user = new User();
        $objUsers = new UserModel();
        $objValidation = new Validations();
        $info = $objValidation->validatesForms($user);

        if (isset($info)) {
            $info[] = 'Ошибка регистрации';
        } else {
            $info = ['Регистрация успешна'];
            $objUsers->addUser($user);
        }
        $this->view->render('registration','Регистрация', $info);
    }
}