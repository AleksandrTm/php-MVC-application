<?php

namespace Core;

use Controllers\AddUsesController;
use Controllers\DeleteUserController;
use Controllers\EditUsersController;
use Controllers\indexController;
use Controllers\LoginController;
use Controllers\ViewUsersController;
use Controllers\NotFoundPageController;
use Controllers\RegistrationController;
use Core\Middleware;

class Routes extends Router
{
    protected static ?Routes $_instance = null;
    protected Middleware $middleware;


    private function __construct()
    {
        parent::__construct();
        $this->router();
        $this->middleware = new Middleware();
    }

    /**
     * Если объект не создан, создаем и отдаём
     * Если объект создан, передаем уже существующий
     */
    public static function getInstance(): Routes
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * Переопределяем функцию клонирования
     * Убираем возможность клонировать существующий объект
     */
    function __clone()
    {
    }

    /**
     * Вызываем нужный контроллер и передаем в него данные
     *
     * Поддержка запросов: GET и POST
     */
    function run(): void
    {
        switch ($this->requestMethod) {
            case 'GET':
                $this->sendGetController();
                break;
            case 'POST':
                $this->sendPostController();
                break;
            default:
                echo "Неизвестный метод запроса";
                break;
        }
    }

    /**
     * Направляем GET запросы
     *
     * Обращается к GET методам контроллера
     */
    function sendGetController(): void
    {
        switch ($this->uri) {
            case "":
                $objIndex = new indexController();
                $objIndex->getIndexPage();
                break;
            case "user/delete":
                $this->middleware->definesAccessRights(['admin']);
                $objDeleteUsers = new DeleteUserController();
                $objDeleteUsers->removesUser($this->path['id']);
            case "view/users":
                $this->middleware->definesAccessRights(['admin', 'member']);
                $objViewsUsers = new ViewUsersController();
                $objViewsUsers->getUsersList();
                break;
            case "login":
                $this->middleware->definesAccessRights(['guest']);
                $objLogin = new LoginController();
                $objLogin->getLoginForm();
                break;
            case "registration":
                $this->middleware->definesAccessRights(['guest']);
                $objReg = new RegistrationController();
                $objReg->getRegistrationForm();
                break;
            case "user/add":
                $this->middleware->definesAccessRights(['admin']);
                $objAddUser = new AddUsesController();
                $objAddUser->getAddUserForm();
                break;
            case "user/edit":
                $this->middleware->definesAccessRights(['admin']);
                $objEditUser = new EditUsersController();
                $objEditUser->getEditUserForm($this->path['id']);
                break;
            case "exit":
                $this->middleware->definesAccessRights(['admin', 'member']);
                $obj = new LoginController();
                $obj->logsOut();
                break;
            default:
                (new NotFoundPageController())->getPage404();
                break;
        }
    }

    /**
     * Направляем POST запросы
     *
     * Обращается к POST методам контроллера
     */
    function sendPostController(): void
    {
        switch ($this->uri) {
            case "view/users":
                $objViewsUsers = new ViewUsersController();
                $objViewsUsers->getUsersList();
                break;
            case "login":
                $objLogin = new LoginController();
                $objLogin->getResultAuthorizationUser();
                break;
            case "registration":
                $objReg = new RegistrationController();
                $objReg->getResultRegistrationUser();
                break;
            case "user/add":
                $objAddUser = new AddUsesController();
                $objAddUser->getResultAddUser();
                break;
            case "user/edit":
                $objEditUser = new EditUsersController();
                $objEditUser->getResultEditUser($this->path['id']);
                break;
            default:
                (new NotFoundPageController())->getPage404();
                break;
        }
    }
}