<?php
require_once "../Config/Autoload.php";

use Config\Paths;

switch ($_SERVER['REQUEST_URI']) {
    case "/":
        require_once Paths::DIR_VIEWS . "viewUsers.php";
        break;
    case "/registration":
        require_once Paths::DIR_VIEWS . "registration.php";
        break;
    case "/login":
        require_once Paths::DIR_VIEWS . "login.php";
        break;
    case "/user/add":
        require_once Paths::DIR_VIEWS . "add-user.php";
        break;
    case "/user/id/delete":
        require_once Paths::DIR_VIEWS . "/";
        break;
    case "/user/if/edit":
        require_once Paths::DIR_VIEWS . "edit-user.php";
        break;
    default:
        require_once Paths::DIR_VIEWS . "page-404.php";
}