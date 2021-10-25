<?php

namespace Controllers;

use Core\Controller;
use Models\UserModel;

/**
 * Отдаёт список пользователей во view
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