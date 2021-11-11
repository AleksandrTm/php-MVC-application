<?php

namespace Controllers;

use Core\Model;
use Entities\User;
use Core\Controller;
use Core\Validations;
use Enums\Database as db;
use Models\UserModel;
use Models\UserModelSQL;

/**
 * Контроллер отвечает за отображение формы добавления пользователя и сохранения пользователя в базу данных
 */
class AddUsesController extends Controller
{
    private Model $model;

    public function __construct()
    {
        parent::__construct();
        if ($this->appConfig['database'] === db::MYSQL) {
            $this->model = new UserModelSQL();
        } else {
            $this->model = new UserModel();
        }
    }

    /**
     * Отображение формы для добавление пользователя
     */
    public function getAddUserForm(): void
    {
        $this->view->render('add-user', 'Добавление пользователя');
    }

    /**
     * Результат отправки формы "добавления пользователя", валидация полей.
     *
     * Сохранение результат в базу данных и вывод результата в вебе.
     */
    public function getResultAddUser(): void
    {
        $user = new User();
        $objValidation = new Validations();

        $info = $objValidation->validatesForms($user);

        if (isset($info)) {
            $info[] = 'Ошибка при добавлении пользователя';
        } else {
            $info = ['Пользователь успешно добавлен'];
            /** Сохраняем пользователя в базу данных при успешной валидации */
            $this->model->addUser($user);
        }

        $this->view->render('add-user','Добавление пользователя', $info);
    }
}