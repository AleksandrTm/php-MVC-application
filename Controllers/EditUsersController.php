<?php

namespace Controllers;

use config\Paths;
use Core\Controller;
use Entities\User;
use Core\Validations;
use Models\UserModel;

class EditUsersController extends Controller
{
    function getEditUserForm(int $id): void
    {
        $obj = new UserModel();

        if ($obj->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
            $this->view->render('edit-user', 'Редактирование пользователя');
        } else {
            $info['userNotFound'] = "Пользователь не найден в базе";
            $this->view->render('edit-user', 'Редактирование пользователя', $info);
        }
    }

    function getResultEditUser(int $id): void
    {
        $objValidation = new Validations();
        $objUserModel = new UserModel();
        $objUser = new User();

        $info = $objValidation->validatesForms($objUser);

        if (isset($info)) {
            $info['resultEdit'] = 'Ошибка редактирования';
        } else {
            $info = ['resultEdit' => 'Редактирование успешно'];
            $objUserModel->editUser($objUser, $id);
        }

        $this->view->render('edit-user', 'Редактирование пользователя', $info);
    }
}