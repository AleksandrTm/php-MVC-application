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
        // Выдаем роль пользователю, если у него её нет
        if (!isset($_SESSION['role'])) $_SESSION['role'] = 'guest';

        $this->method = htmlspecialchars($_SERVER['REQUEST_METHOD']);
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
     * Обрабатывает Path и разбивает на параметры
     * Отдаёт именнованый массив с параметрами: path/param + id
     * При отсутсвии id, отдаёт: path/param
     */
    function router($path): array
    {
        $parsPath = explode('/', $path);
        preg_match("([0-9]+)", array_key_exists(2, $parsPath) ? $parsPath[2] : null, $id);

        /**
         * Проверка на отсутсвие параметра id в path
         */
        if (count($parsPath) == 3) {
            $path = ['url' => array_key_exists(1, $parsPath) ? $parsPath[1] : null,
                'param' => array_key_exists(2, $parsPath) ? $parsPath[2] : null,
                'id' => array_key_exists(0, $id) ? $id[0] : null
            ];
        } else {
            $path = ['url' => array_key_exists(1, $parsPath) ? $parsPath[1] : null,
                'param' => array_key_exists(3, $parsPath) ? $parsPath[3] : null,
                'id' => array_key_exists(0, $id) ? $id[0] : null
            ];
        }
        return $path;
    }

    /**
     * Направляем GET запросы
     *
     * Обращается к GET методам контроллера
     */
    function sendGetController(): void
    {
        $path = $this->router($this->path);
        $param = !is_null($path['param']) ? $path['url'] . "/" . $path['param'] : $path['url'];

        switch ($param) {
            case "user/delete":
                $objDeleteUsers = new DeleteUserController();
                $objDeleteUsers->get($path['id']);
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
                $objEditUser->get($path['id']);
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
        $path = $this->router($this->path);
        $param = !is_null($path['param']) ? $path['url'] . "/" . $path['param'] : $path['url'];

        switch ($param) {
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
                $objEditUser->post($path['id']);
                break;
            default:
                (new NotFoundPageController())->page404();
                break;
        }
    }
}