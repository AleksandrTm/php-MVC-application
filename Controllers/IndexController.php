<?php

namespace Controllers;

use Core\Controller;

/**
 * Главная страница сайта по URI /
 */
class IndexController extends Controller
{
    public function getIndexPage(): void
    {
        $this->view->render('index', 'Главная страница');
    }
}