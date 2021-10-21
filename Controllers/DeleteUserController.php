<?php

namespace Controllers;

use Core\Controller;
use Models\UserModel;

class DeleteUserController extends Controller
{
    function removesUser(int $id): void
    {
        $obj = new UserModel();
        if ($obj->findUser($id)) {
            $obj->deleteUser($id);
        } else {
            header('Location: http://localsite.ru');
            exit();
        }
    }
}