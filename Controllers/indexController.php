<?php

namespace Controllers;

use Core\Controller;

/**
 * Главная страница сайта по URI /
 */
class indexController extends Controller
{
    function getIndexPage(): void
    {
        $this->view->render('index', 'Главная страница');
    }
}