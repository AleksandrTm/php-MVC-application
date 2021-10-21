<?php

namespace Controllers;

use Core\Controller;
use Models\UserModel;

/**
 * Controller для отображения пользователей с модели
 */
class ViewUsersController extends Controller
{
    public function getUsersList(): void
    {
        $objUsers = new UserModel();
        $dataAllUsers = $objUsers->getDataAllUsers();
        $this->view->render('views-users','Список пользователей', $dataAllUsers);
    }
}