<?php

namespace Controllers;

use Core\Controller;
use Core\Model;
use Enums\Database as db;
use Models\UserModel;
use Models\UserModelSQL;

/**
 * Отдаёт список пользователей во view
 */
class ViewUsersController extends Controller
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

    public function getUsersList(): void
    {
        $dataAllUsers = $this->model->getDataUsers();

        $this->view->render('views-users','Список пользователей', $dataAllUsers);
    }
}