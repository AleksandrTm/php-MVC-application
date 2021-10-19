<?php

namespace Controllers;

use Models\Users as Users;
use Core\Middleware;

/**
 * Controller для отображения пользователей с модели
 */
class ViewUsersController extends Middleware
{
    public function getUsersList()
    {
        $objUsers = new Users();
        $arrayUsers = $objUsers->views();

        include_once "../views/views-users.php";
    }
}