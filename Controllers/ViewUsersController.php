<?php

namespace Controllers;

use Core\Controller;
use Models\Users;

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