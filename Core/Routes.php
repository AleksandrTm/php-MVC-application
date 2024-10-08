<?php

namespace Core;

use Controllers\AddUsesController;
use Controllers\ArticlesController;
use Controllers\DeleteUserController;
use Controllers\EditUsersController;
use Controllers\IndexController;
use Controllers\ItemsController;
use Controllers\LoginController;
use Controllers\NewsController;
use Controllers\ViewUsersController;
use Controllers\NotFoundPageController;
use Controllers\RegistrationController;

use Enums\Permissions as access;

class Routes extends Router
{
    protected static ?Routes $_instance = null;
    protected Middleware $middleware;


    private function __construct()
    {
        parent::__construct();
        $this->router();
        $this->middleware = new Middleware();
        $this->run();
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
    public function sendGetController(): void
    {
        switch ($this->uri) {
            case "":
                $objIndex = new IndexController();
                $objIndex->getIndexPage();
                break;
            case "items":
                $objIndex = new ItemsController();
                $objIndex->getItemsPagePost();
                break;
            case "user/delete":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $objDeleteUsers = new DeleteUserController();
                $objDeleteUsers->removesUser($this->path['id']);
                break;
            case "view/users":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN'], access::ROLE['MEMBER']]);
                $objViewsUsers = new ViewUsersController();
                $objViewsUsers->getUsersList();
                break;
            case "login":
                $this->middleware->definesAccessRights([access::ROLE['GUEST']]);
                $objLogin = new LoginController();
                $objLogin->getLoginForm();
                break;
            case "registration":
                $this->middleware->definesAccessRights([access::ROLE['GUEST']]);
                $objReg = new RegistrationController();
                $objReg->getRegistrationForm();
                break;
            case "user/add":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $objAddUser = new AddUsesController();
                $objAddUser->getAddUserForm();
                break;
            case "user/edit":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $objEditUser = new EditUsersController();
                $objEditUser->getEditUserForm($this->path['id']);
                break;
            case "exit":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN'], access::ROLE['MEMBER']]);
                $obj = new LoginController();
                $obj->logsOut();
                break;
            case "news/add":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $obj = new NewsController();
                $obj->getAddNewsForm();
                break;
            case "news/edit":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $obj = new NewsController();
                $obj->getEditNewsForm($this->path['id']);
                break;
            case "news/delete":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $obj = new NewsController();
                $obj->removesNews($this->path['id']);
                break;
            case "news":
                $obj = new NewsController();
                $obj->getNewsPage();
                break;
            case "news/view":
                $obj = new NewsController();
                $obj->getFullNewsPage($this->path['id']);
                break;
            case "articles/view":
                $obj = new ArticlesController();
                $obj->getFullArticlePage($this->path['id']);
                break;
            case "articles/add":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $obj = new ArticlesController();
                $obj->getAddArticleForm();
                break;
            case "articles/edit":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $obj = new ArticlesController();
                $obj->getEditArticleForm($this->path['id']);
                break;
            case "articles/delete":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $obj = new ArticlesController();
                $obj->removesArticle($this->path['id']);
                break;
            case "articles":
                $obj = new ArticlesController();
                $obj->getArticlesPage();
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
    public function sendPostController(): void
    {
        switch ($this->uri) {
            case "":
                $objIndex = new IndexController();
                $objIndex->getIndexPagePost();
                break;
            case "items":
                $objIndex = new ItemsController();
                $objIndex->getItemsPagePost();
                break;
            case "view/users":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $objViewsUsers = new ViewUsersController();
                $objViewsUsers->getUsersList();
                break;
            case "login":
                $this->middleware->definesAccessRights([access::ROLE['GUEST']]);
                $objLogin = new LoginController();
                $objLogin->getResultAuthorizationUser();
                break;
            case "registration":
                $this->middleware->definesAccessRights([access::ROLE['GUEST']]);
                $objReg = new RegistrationController();
                $objReg->getResultRegistrationUser();
                break;
            case "user/add":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $objAddUser = new AddUsesController();
                $objAddUser->getResultAddUser();
                break;
            case "user/edit":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $objEditUser = new EditUsersController();
                $objEditUser->getResultEditUser($this->path['id']);
                break;
            case "articles/add":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $obj = new ArticlesController();
                $obj->getResultAddArticle();
                break;
            case "articles/edit":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $objEditArticle = new ArticlesController();
                $objEditArticle->getResultEditArticle($this->path['id']);
                break;
            case "news/add":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $obj = new NewsController();
                $obj->getResultAddNews();
                break;
            case "news/edit":
                $this->middleware->definesAccessRights([access::ROLE['ADMIN']]);
                $objEditArticle = new NewsController();
                $objEditArticle->getResultEditNews($this->path['id']);
                break;
            default:
                (new NotFoundPageController())->getPage404();
                break;
        }
    }
}