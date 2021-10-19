<?php

namespace Core;

use Controllers\AddUsesController;
use Controllers\DeleteUserController;
use Controllers\EditUsersController;
use Controllers\LoginController;
use Controllers\ViewUsersController;
use Controllers\NotFoundPageController;
use Controllers\RegistrationController;

class Routes extends Middleware
{
    protected static ?Routes $_instance = null;

    private function __construct()
    {
        parent::__construct();
        $this->middleware();
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
        switch ($this->method) {
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
            case "user/delete":
                $objDeleteUsers = new DeleteUserController();
                $objDeleteUsers->get($this->pathArray['id']);
            case "":
                $objViewsUsers = new ViewUsersController();
                $objViewsUsers->getUsersList();
                break;
            case "login":
                $objLogin = new LoginController();
                $objLogin->get();
                break;
            case "registration":
                $objReg = new RegistrationController();
                $objReg->get();
                break;
            case "user/add":
                $objAddUser = new AddUsesController();
                $objAddUser->get();
                break;
            case "user/edit":
                $objEditUser = new EditUsersController();
                $objEditUser->get($this->pathArray['id']);
                break;
            case "exit":
                $obj = new LoginController();
                $obj->exit();
                break;
            default:
                (new NotFoundPageController())->page404();
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
            case "":
                $objViewsUsers = new ViewUsersController();
                $objViewsUsers->getUsersList();
                break;
            case "login":
                $objLogin = new LoginController();
                $objLogin->post();
                break;
            case "registration":
                $objReg = new RegistrationController();
                $objReg->post();
                break;
            case "user/add":
                $objAddUser = new AddUsesController();
                $objAddUser->post();
                break;
            case "user/edit":
                $objEditUser = new EditUsersController();
                $objEditUser->post($this->pathArray['id']);
                break;
            default:
                (new NotFoundPageController())->page404();
                break;
        }
    }
}