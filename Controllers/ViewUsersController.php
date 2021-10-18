<?php

namespace Controllers;

use Models\Users as Users;
use Core\Controller;

/**
 * Controller для отображения пользователей с модели
 */
class ViewUsersController extends Controller
{
    public function getUsersList()
    {
        $objUsers = new Users();
        $arrayUsers = $objUsers->views();

        include_once "../views/views-users.php";
    }
}