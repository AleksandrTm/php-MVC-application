<?php

namespace Controllers;

use Core\Controller;
use Core\Validations;
use Entities\Content;
use Enums\Database as db;
use Models\ArticlesModel;
use Enums\Paths;

/**
 * Контроллер Статей
 */
class ArticlesController extends Controller
{
    protected string $database = Paths::DIR_BASE_ARTICLES;
    protected ?array $content = null;

    /**
     * Получает все статьи из базы данных и передаёт их во View
     */
    public function getArticlesPage(): void
    {
        $objArticles = new ArticlesModel();

        /** Хранит все статьи по id */
        $this->content['content'] = $objArticles->getDataAllArticles();

        /** Заголовок статьи <h3> */
        $this->content['titleContent'] = 'Список статей';

        /** Тип передаваемого контента во view */
        $this->content['typeContent'] = 'articles';

        $this->view->render('content', 'Статьи', $this->content);
    }

    /**
     * Получаем страницу с полной статьей
     */
    public function getFullArticlePage($id): void
    {

        $objArticle = new ArticlesModel();

        if ($this->appConfig['database'] === db::FILES) {
            $this->content = $objArticle->getContentByID($id, $this->database);
        } else {
            $this->content = $objArticle->getContentByID($id, 'articles');
        }

        if (!is_null($this->content)) {
            $this->view->render('full-content', 'Статья', $this->content);
        } else {
            $this->view->render('page-404', 'Статья не найдена');
        }
    }

    /**
     * Получаем страницу с формой добавления статьи
     */
    public function getAddArticleForm(): void
    {
        $this->content['title'] = 'Добавление статьи';

        $this->view->render('content-action', $this->content['title'], $this->content);
    }

    /**
     * Получаем страницу с формой редактирования статьи
     */
    public function getEditArticleForm(int $id): void
    {
        $objArticle = new ArticlesModel();

        if ($this->appConfig['database'] === db::FILES) {
            $this->content['data'] = $objArticle->getContentByID($id, $this->database);
        } else {
            $this->content['data'] = $objArticle->getContentByID($id, db::ARTICLES);
        }

        $this->content['title'] = 'Редактирование статьи';

        $this->view->render('content-action', $this->content['title'], $this->content);
    }

    /**
     * Результат редактирования статьи и сохранение в базу данных
     *
     * Валидация полей
     */
    public function getResultEditArticle(int $id): void
    {
        $objValidation = new Validations();
        $objArticleModel = new ArticlesModel();
        $objContent = new Content();

        $this->content = $objValidation->validatesFormsContent($objContent);

        if (isset($this->content)) {
            $this->content['result'] = 'Ошибка редактирования';
        } else {
            $this->content = ['result' => 'Редактирование успешно'];

            if ($this->appConfig['database'] === db::MYSQL) {
                $objArticleModel->updateData($objContent, db::ARTICLES, $id);
            } else {
                $objArticleModel->editContent($objContent, $id, $this->database);
            }
        }

        $this->getEditArticleForm($id);
    }

    /**
     * Удаляет нужную статью по id
     */
    public function removesArticle($id): void
    {
        $objArticles = new ArticlesModel();

        if ($this->appConfig['database'] === db::MYSQL) {
            $result = $objArticles->removesContent(db::ARTICLES, $id);
        } else {
            $result = $objArticles->removesContent($this->database, $id);
        }
        if ($result) {
            $this->content['resultDelete'] = 'Статья успешно удалена';
        } else {
            $this->content['resultDelete'] = 'Ошибка удаления статьи';
        }
        $this->getArticlesPage();
    }

    /**
     * Результат добавления статьи в базу данных
     */
    public function getResultAddArticle(): void
    {
        $objValidation = new Validations();
        $objArticleModel = new ArticlesModel();
        $objContent = new Content();

        $this->content = $objValidation->validatesFormsContent($objContent);

        if (isset($this->content)) {
            $this->content['result'] = 'Ошибка добавления статьи';
        } else {
            $this->content = ['result' => 'Статья успешно добавлена'];

            if ($this->appConfig['database'] === db::FILES) {
                $objArticleModel->addContent($objContent, $this->database);
            } else {
                $objArticleModel->writeData($objContent, db::ARTICLES);
            }
        }

        $this->view->render('content-action', 'Добавление статьи', $this->content);
    }
}