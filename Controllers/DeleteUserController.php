<?php

namespace Controllers;

use Core\Controller;
use Models\Users;

class DeleteUserController extends Controller
{
    function get($urlId)
    {
        $id = preg_replace("/[^,.0-9]/", '', $urlId);
        $obj = new Users();
        $obj->deleteUser($id);
    }
}