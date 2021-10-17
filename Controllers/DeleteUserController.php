<?php

namespace Controllers;

use Core\Controller;
use Models\Users;

class DeleteUserController extends Controller
{
    function get($id)
    {
        $obj = new Users();
        $obj->deleteUser($id);
    }
}