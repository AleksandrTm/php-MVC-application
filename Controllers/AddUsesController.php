<?php

namespace Controllers;

use Core\User;
use Core\Controller;
use Core\Validations;
use Models\UserModel;

/**
 * Контроллер отвечает за отображение формы добавления пользователей и
 */
class AddUsesController extends Controller
{
    function getAddUserForm(): void
    {
        $this->view->render('add-user', 'Добавление пользователя');
    }

    function getResultAddUser(): void
    {
        $user = new User();
        $objUsers = new UserModel();
        $objValidation = new Validations();
        $info = $objValidation->validatesForms($user);

        if (isset($info)) {
            $info[] = 'Ошибка при добавлении пользователя';
        } else {
            $info = ['Пользователь успешно добавлен'];
            $objUsers->addUser($user);
        }
        $this->view->render('add-user','Добавление пользователя', $info);
    }
}