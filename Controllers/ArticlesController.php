<?php

namespace Controllers;

use Core\Controller;
use Models\ArticlesModel;

/**
 * Контроллер Статей
 */
class ArticlesController extends Controller
{
    /**
     * Получает все статьи из базы данных и передаёт их во View
     */
    function getArticlesPage()
    {
        $objArticles = new ArticlesModel();
        $content = $objArticles->getDataAllArticles();
        $this->view->render('article', 'Статьи', $content);
    }

    function getFullArticlePage($id)
    {
        $content[] = ['idArticle' => $id];

        $this->view->render('full-article', 'Статьи', $content);
    }
}