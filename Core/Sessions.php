<?php

namespace Core;

use Entities\User;
use Enums\Database as db;
use Enums\Paths;
use Enums\Permissions;
use Models\UserModel;

class Sessions
{
    /**
     * Проверка текущей сессии пользователя
     *
     * Обновляет текущие права, если есть такая необходимость
     *
     * Права для не авторизованных пользователей: GUEST
     */
    public function checksSession(): void
    {
        $objModel = new UserModel();

        if (isset($_SESSION['id'])) {

            if ($objModel->appConfig['database'] === db::FILES) {
                $statusUser = $objModel->checksExistenceRecord(Paths::DIR_BASE_USERS, $_SESSION['id']);
                $user = $objModel->checksUserRole(Paths::DIR_BASE_USERS, $_SESSION['id'], new User);
            } else {
                $statusUser = $objModel->checksExistenceRecord(db::USERS, $_SESSION['id']);
                $user = $objModel->checksUserRole(db::USERS, $_SESSION['id'], new User);
            }

            if (!$statusUser) {
                session_destroy();
                $_SESSION['role'] = Permissions::ROLE['GUEST'];
                return;
            }
            if ($_SESSION['role'] != $user->getRole()) {
                $_SESSION['role'] = $user->getRole();
            }

        }
        if (!isset($_SESSION['role'])) {
            $_SESSION['role'] = Permissions::ROLE['GUEST'];
        }
    }
}