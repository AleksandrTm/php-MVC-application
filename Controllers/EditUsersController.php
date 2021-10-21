<?php

namespace Controllers;

use Core\Controller;
use Core\Middleware;
use Core\Validations;
use Models\UserModel;

class EditUsersController extends Controller
{
    function getEditUserForm($id): void
    {
        if ((new UserModel())->findUser($id)) {
            $this->view->render('edit-user', 'Редактирование пользователя');
        } else {
            $info['userNotFound'] = "Пользователь не найден в базе";
            $this->view->render('edit-user', 'Редактирование пользователя', $info);
        }
    }

    function getResultEditUser($id): void
    {
//        $obj = new Validations();
//        $info = $obj->mainForm($_POST['login'], $_POST['password'], $_POST['passwordConfirm'], $_POST['email'],
//            $_POST['fullName'], $_POST['date'], $_POST['about'], $id);
//        include_once "../views/edit-user.php";
    }
}