<?php

namespace Controllers;

use Core\Controller;
use Core\Validation;
use Models\Users;

class AddUsesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function get()
    {
        $info = include_once "../views/temp/form-add-user.html.php";
        include_once "../views/add-user.html.php";
    }

    function post()
    {
        $objValidation = new Validation();
        $info = $objValidation->validation();

        empty($info) ? $objUsers = new Users() : $objUsers = null;



        include_once "../views/add-user.html.php";
    }
}