<?php

namespace Controllers;

use Enums\Paths;
use Core\Controller;
use Entities\User;
use Core\Validations;
use Models\UserModel;
use Enums\Database as db;

class EditUsersController extends Controller
{
    protected ?array $content = null;

    public function getEditUserForm(int $id): void
    {
        $obj = new UserModel();

        $this->content['data'] = $obj->getDataUser($id);

        if ($obj->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
            $this->view->render('edit-user', 'Редактирование пользователя', $this->content);
        } else {
            $this->content['userNotFound'] = "Пользователь не найден в базе";
            $this->view->render('edit-user', 'Редактирование пользователя', $this->content);
        }

//        if ($this->appConfig['database'] === db::FILES) {
//            $this->content['data'] = $obj->getDataUser($id);
//        } else {
//            $this->content['data'] = $obj->getDataUser($id);
//        }
    }

    public function getResultEditUser(int $id): void
    {
        $objValidation = new Validations();
        $objUserModel = new UserModel();
        $objUser = new User();

        $this->content['valid'] = $objValidation->validatesForms($objUser);

        if (isset($info)) {
            $this->content['resultEdit'] = 'Ошибка редактирования';
        } else {
            $this->content['resultEdit'] = 'Редактирование успешно';
            $objUserModel->editUser($objUser, $id);
        }

        $this->getEditUserForm($id);
//        $this->view->render('edit-user', 'Редактирование пользователя', $info);
    }
}