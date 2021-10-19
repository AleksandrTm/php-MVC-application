<?php

namespace Controllers;

use Core\Controller;
use Core\Validation;

class RegistrationController extends Controller
{
    function get()
    {
        include_once "../views/registration-user.html.php";
    }

    function post()
    {
        $obj = new Validation();
        $info = $obj->validation();
        include_once "../views/registration-user.html.php";
    }
}