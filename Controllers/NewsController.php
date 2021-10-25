<?php

namespace Controllers;

use config\Paths;
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
        $content['content'] = $objNews->getNewsFromTheLastDay();
        $content['titleContent'] = 'Список новостей за последнии 24 часа';
        $content['typeContent'] = 'news';

        $this->view->render('content', 'Новости', $content);
    }

    function getFullNewsPage($id)
    {
        $objNews = new NewsModel();
        $content = $objNews->getContentByID($id, Paths::DIR_BASE_NEWS);

        $this->view->render('full-content', 'Новость', $content);
    }
}