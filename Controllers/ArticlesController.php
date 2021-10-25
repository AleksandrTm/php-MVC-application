<?php

namespace Controllers;

use config\Paths;
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
    function getArticlesPage(): void
    {
        $objArticles = new ArticlesModel();

        /** Хранит все статьи по id */
        $content['content'] = $objArticles->getDataAllArticles();

        /** Заголовок */
        $content['titleContent'] = 'Список статей';

        /** Тип передаваемого контента во view */
        $content['typeContent'] = 'articles';

        $this->view->render('content', 'Статьи', $content);
    }

    /**
     * Получаем страницу с полной статьей
     */
    function getFullArticlePage(int $id): void
    {
        $objArticle = new ArticlesModel();
        $content = $objArticle->getContentByID($id, Paths::DIR_BASE_ARTICLES);

        $this->view->render('full-content', 'Статьи', $content);
    }
    function removesContent(int $id): void
    {
        $objArticles = new ArticlesModel();

        /**
         * Проверка на существования пользователя в базе данных и последующих действий с ним
         */
        if ($objArticles->checksExistenceRecord(Paths::DIR_BASE_ARTICLES, $id)) {
            /** Удаляем пользователя и остаёмся на текущей странице */
            $objArticles->delete($id, Paths::DIR_BASE_ARTICLES);
        } else {
            /** Если статья не найден в базе, отправляем на главную */
            header('Location: http://localsite.ru');
            exit();
        }
    }

    function getAddContentForm()
    {
        $this->view->render('content-action', 'Добавление контента');
    }
}