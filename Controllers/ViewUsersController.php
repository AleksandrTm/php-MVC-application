<?php

namespace Controllers;

use Models\Users as Users;
use Core\Controller;

/**
 * Controller для отображения пользователей с модели
 */
class ViewUsersController extends Controller
{
    // Хранение пользователей для отдачи во views
    public static ?array $arrayUsers = null;

    public function getUsersList()
    {
        self::$arrayUsers = Users::views();
        include_once "../views/views-users.php";
    }
}