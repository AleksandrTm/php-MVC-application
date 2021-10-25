<?php

namespace Controllers;

use Core\Controller;
use Models\NewsModel;

class NewsController extends Controller
{
    /**
     * Получает все новости из базы данных и передаёт их во View
     */
    function getNewsPage()
    {
        $objNews = new NewsModel();
        $content = $objNews->getNewsFromTheLastDay();
        $this->view->render('news', 'Новости', $content);
    }

    function getFullNewsPage($id)
    {
        $content[] = ['idNews' => $id];

        $this->view->render('full-news', 'Новость', $content);
    }
}