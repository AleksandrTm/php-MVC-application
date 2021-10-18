<?php

namespace Controllers;

use config\Paths;
use Core\Middleware;

class NotFoundPageController extends Middleware
{
    function page404()
    {
        include_once Paths::DIR_VIEWS . "page-404.php";
    }
}