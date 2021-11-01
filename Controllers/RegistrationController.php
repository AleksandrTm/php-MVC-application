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
            $objUsers->addUser($user);
        }
        $this->view->render('registration','Регистрация', $info);
    }
}