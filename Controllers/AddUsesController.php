<?php

namespace Controllers;

use Entities\User;
use Core\Controller;
use Core\Validations;
use Models\UserModel;

/**
 * Контроллер отвечает за отображение формы добавления пользователя и сохранения пользователя в базу данных
 */
class AddUsesController extends Controller
{
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
        $objUsers = new UserModel();
        $objValidation = new Validations();

        $info = $objValidation->validatesForms($user);

        if (isset($info)) {
            $info[] = 'Ошибка при добавлении пользователя';
        } else {
            $info = ['Пользователь успешно добавлен'];
            /** Сохраняем пользователя в базу данных при успешной валидации */
            $objUsers->addUser($user);
        }

        $this->view->render('add-user','Добавление пользователя', $info);
    }
}