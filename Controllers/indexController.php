<?php

namespace Controllers;

use Core\Controller;

class indexController extends Controller
{
    function getIndexPage(): void
    {
        $this->view->render('index', 'Главная страница');
    }
}