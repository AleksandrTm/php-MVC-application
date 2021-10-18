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
        if ($this->generalRules()) {
            $arrayUsers = $objUsers->views();
        } else {
            $arrayUsers = [];
            $info = "нет прав, требуется авторизация";
        }
        include_once "../views/views-users.php";
    }
}