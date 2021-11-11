<?php

namespace Controllers;

use Core\Model;
use Enums\Database as db;
use Enums\Paths;
use Core\Controller;
use Models\UserModel;
use Models\UserModelSQL;

/**
 * Удаление пользователя по его id
 *
 * Проверка на существования пользователя в базе данных и последующих действий с ним
 */
class DeleteUserController extends Controller
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

    public function removesUser(int $id): void
    {
        if ($this->model->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
            $status = $this->model->removeFromTheDatabase($id, Paths::DIR_BASE_USERS);

            $info['statusRemove'] = $status ? 'Пользователь успешно удалён' : 'Ошибка удаления';

            $this->view->render('views-users', 'Список пользователей', $info);
        } else {
            /** Если пользователь не найден в базе, отправляем на главную */
            header('Location: http://localsite.ru');
        }
    }
}