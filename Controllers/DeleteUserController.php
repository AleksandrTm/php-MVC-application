<?php

namespace Controllers;

use Core\Middleware;
use Models\Users;

class DeleteUserController extends Middleware
{

    function get(int $id)
    {
        $obj = new Users();
        if ($obj->findUser($id)) {
            $obj->deleteUser($id);
        } else {
            header('Location: http://localsite.ru');
            exit();
        }
    }
}