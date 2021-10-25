<?php

namespace Controllers;

use config\Paths;
use Core\Controller;
use Models\UserModel;

/**
 * Удаление пользователя по его id
 */
class DeleteUserController extends Controller
{
    function removesUser(int $id): void
    {
        $obj = new UserModel();

        /**
         * Проверка на существования пользователя в базе данных и последующих действий с ним
         */
        if ($obj->checksExistenceRecord(Paths::DIR_BASE_USERS, $id)) {
            /** Удаляем пользователя и остаёмся на текущей странице */
            $obj->delete($id, Paths::DIR_BASE_USERS);
        } else {
            /** Если пользователь не найден в базе, отправляем на главную */
            header('Location: http://localsite.ru');
            exit();
        }
    }
}