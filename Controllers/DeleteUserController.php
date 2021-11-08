<?php

namespace Controllers;

use Enums\Paths;
use Core\Controller;
use Models\UserModel;

/**
 * Удаление пользователя по его id
 *
 * Проверка на существования пользователя в базе данных и последующих действий с ним
 */
class DeleteUserController extends Controller
{
    public function removesUser(int $id): void
    {
        $userModel = new UserModel();

        if ($userModel->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
            $status = $userModel->removeFromTheDatabase($id, Paths::DIR_BASE_USERS);

            $info['statusRemove'] = $status ? 'Пользователь успешно удалён' : 'Ошибка удаления';

            $this->view->render('views-users', 'Список пользователей', $info);
        } else {
            /** Если пользователь не найден в базе, отправляем на главную */
            header('Location: http://localsite.ru');
            exit();
        }
    }
}