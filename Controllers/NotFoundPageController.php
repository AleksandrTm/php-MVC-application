<?php

namespace Controllers;

use Core\Controller;

/**
 * Отдаёт 404 ошибку, в случае если пользователь зашёл на несуществующий URI
 */
class NotFoundPageController extends Controller
{
    public function getPage404(): void
    {
        $this->view->render('page-404', 'Страница не найдена');
    }
}