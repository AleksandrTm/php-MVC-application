<?php

namespace Controllers;

use Core\Controller;
use Core\Authorization;


class LoginController extends Controller
{
    public ?string $info = null;

    public Authorization $authorization;

    public function __construct()
    {
        $this->authorization = new Authorization();
    }

    public function get()
    {
        include_once "../views/login.html.php";
    }

    function post()
    {
        $this->authorization->authentication();
        header('Location: http://localsite.ru');
        exit;
    }

    public function exit()
    {
        $this->authorization->out();
    }
}