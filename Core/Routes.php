<?php

namespace Core;

use Controllers\AddUsesController;
use Controllers\DeleteUserController;
use Controllers\EditUsersController;
use Controllers\LoginController;
use Controllers\ViewUsersController;
use Controllers\NotFoundPageController;
use Controllers\RegistrationController;

class Routes
{
    protected static ?Routes $_instance = null;
    public string $method;
    public string $path;

    private function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = htmlspecialchars($_SERVER['REQUEST_URI']);
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
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /**
         * ВЫНЕСТИ В КОНФИГ, ВРЕМЕННАЯ РЕАЛИЗАЦИЯ
         */
        preg_match("/(^\/user\/)([0-9]+)(\/edit)/", $this->path, $editUser);
        preg_match("/(^\/user\/)([0-9]+)(\/delete)/", $this->path, $urlDeleteUser);
        /**
         * Проверяем на пустой массив, избежание ошибок при пустом массиве при прохождении по кейсам
         */
        $urlEditUser = !empty($editUser[0]) ? $editUser[0] : null;
        $urlDeleteUser = !empty($urlDeleteUser[0]) ? $urlDeleteUser[0] : null;
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        switch ($this->path) {
            case $urlDeleteUser:
                $objDeleteUsers = new DeleteUserController();
                $objDeleteUsers->get($urlDeleteUser);
            case "/":
                $objViewsUsers = new ViewUsersController();
                $objViewsUsers->main();
                break;
            case "/login":
                $objLogin = new LoginController();
                $objLogin->get();
                break;
            case "/registration":
                $objReg = new RegistrationController();
                $objReg->get();
                break;
            case "/user/add":
                $objAddUser = new AddUsesController();
                $objAddUser->get();
                break;
            case $urlEditUser:
                $objEditUser = new EditUsersController();
                $objEditUser->get();
                break;
            default:
                NotFoundPageController::page404();
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
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /**
         * ВЫНЕСТИ В КОНФИГ, ВРЕМЕННАЯ РЕАЛИЗАЦИЯ
         */
        preg_match("/(^\/user\/)([0-9]+)(\/edit)/", $this->path, $editUser);
        preg_match("/(^\/user\/)([0-9]+)(\/delete)/", $this->path, $urlDeleteUser);
        /**
         * Проверяем на пустой массив, избежание ошибок при пустом массиве при прохождении по кейсам
         */
        $urlEditUser = !empty($editUser[0]) ? $editUser[0] : null;
        $urlDeleteUser = !empty($urlDeleteUser[0]) ? $urlDeleteUser[0] : null;
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        switch ($this->path) {
            case "/login":
                $objLogin = new LoginController();
                $objLogin->post();
                break;
            case "/registration":
                $objReg = new RegistrationController();
                $objReg->post();
                break;
            case "/user/add":
                $objAddUser = new AddUsesController();
                $objAddUser->post();
                break;
            case $urlEditUser:
                $objEditUser = new EditUsersController();
                $objEditUser->post($urlEditUser);
                break;
            default:
                NotFoundPageController::page404();
                break;
        }
    }
}