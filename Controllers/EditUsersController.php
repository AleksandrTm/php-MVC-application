<?php

namespace Controllers;

use Core\Model;
use Enums\Paths;
use Core\Controller;
use Entities\User;
use Core\Validations;
use Models\UserModel;
use Enums\Database as db;
use Models\UserModelSQL;

class EditUsersController extends Controller
{
    protected ?array $content = null;
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

    public function getEditUserForm(int $id): void
    {
        $this->content['data'] = $this->model->getDataUser($id);

        if ($this->model->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
            $this->view->render('edit-user', 'Редактирование пользователя', $this->content);
        } else {
            $this->content['userNotFound'] = "Пользователь не найден в базе";
            $this->view->render('edit-user', 'Редактирование пользователя', $this->content);
        }
    }

    public function getResultEditUser(int $id): void
    {
        $objValidation = new Validations();
        $objUser = new User();

        $this->content['valid'] = $objValidation->validatesForms($objUser);
        if (isset($this->content['valid'])) {
            $this->content['resultEdit'] = 'Ошибка редактирования';
        } else {
            $this->content['resultEdit'] = 'Редактирование успешно';
            $this->model->editUser($objUser, $id);
        }

        $this->getEditUserForm($id);
    }
}