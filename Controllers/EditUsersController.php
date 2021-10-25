<?php

namespace Controllers;

use config\Paths;
use Core\Controller;
use Core\User;
use Core\Validations;
use Models\UserModel;

class EditUsersController extends Controller
{
    function getEditUserForm($id): void
    {
        if ((new UserModel())->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
            $this->view->render('edit-user', 'Редактирование пользователя');
        } else {
            $info['userNotFound'] = "Пользователь не найден в базе";
            $this->view->render('edit-user', 'Редактирование пользователя', $info);
        }
    }

    function getResultEditUser($id): void
    {
        $objValidation = new Validations();
        $objUserModel = new UserModel();
        $objUser = new User();

        $info = $objValidation->validatesForms($objUser);

                if (isset($info)) {
                    $info[] = 'Ошибка редактирования';
                } else {
                    $info = ['resultEdit' => 'Редактирование успешно'];
                    $objUserModel->editUser($objUser, $id);
                }

        $this->view->render('edit-user', 'Редактирование пользователя', $info);
    }
}