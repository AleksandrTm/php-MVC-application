<?php

namespace Controllers;

use config\Paths;
use Core\Controller;

class NotFoundPageController extends Controller
{
    static function page404()
    {
        include_once Paths::DIR_VIEWS . "page-404.php";
    }
}