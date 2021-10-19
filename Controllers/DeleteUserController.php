<?php

namespace Controllers;

use Core\Controller;
use Models\Users;

class DeleteUserController extends Controller
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