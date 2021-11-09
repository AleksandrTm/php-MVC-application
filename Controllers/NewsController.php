<?php

namespace Controllers;

use Enums\Database as db;
use Enums\Paths;
use Core\Controller;
use Core\Validations;
use Entities\Content;
use Models\NewsModel;

class NewsController extends Controller
{
    protected string $database = Paths::DIR_BASE_NEWS;
    protected ?array $content = null;

    /**
     * Получает все новости из базы данных и передаёт их во View
     */
    public function getNewsPage(): void
    {
        $objNews = new NewsModel();

        $this->content['content'] = $objNews->getNewsFromTheLastDay();
        $this->content['titleContent'] = 'Список новостей за последнии 24 часа';
        $this->content['typeContent'] = 'news';

        $this->view->render('content', 'Новости', $this->content);
    }

    /**
     * Получаем страницу с полной новостью
     */
    public function getFullNewsPage($id): void
    {
        $objNews = new NewsModel();

        $this->content = $objNews->getNewsFromTheLastDay();
        if ($this->appConfig['database'] === db::FILES) {
            $this->content = $objNews->getContentByID($id, $this->database);
        } else {
            $this->content = $objNews->getContentByID($id, 'news');
        }

        if (!is_null($this->content)) {
            $this->view->render('full-content', 'Новость', $this->content);
        } else {
            $this->view->render('page-404', 'Статья не найдена');
        }
    }

    /**
     * Получаем страницу с формой добавления новости
     */
    public function getAddNewsForm(): void
    {
        $this->content['title'] = 'Добавление новости';

        $this->view->render('content-action', $this->content['title'], $this->content);

    }

    /**
     * Получаем страницу с формой редактирования новости
     */
    public function getEditNewsForm(): void
    {
        $this->content['title'] = 'Редактирование новости';

        $this->view->render('content-action', $this->content['title'], $this->content);
    }

    /**
     * Удаляет нужную новость по id
     */
    public function removesNews(int $id): void
    {
        $objNews = new NewsModel();

        if ($this->appConfig['database'] === db::MYSQL) {
            $result = $objNews->removesContent(db::NEWS, $id);
        } else {
            $result = $objNews->removesContent($this->database, $id);
        }
        if ($result) {
            $this->content['resultDelete'] = 'Новость успешно удалена';
        } else {
            $this->content['resultDelete'] = 'Ошибка удаления новости';
        }
        $this->getNewsPage();
    }

    /**
     * Результат добавления новости в базу данных
     */
    public function getResultAddNews(): void
    {
        $objValidation = new Validations();
        $objNewsModel = new NewsModel();
        $objContent = new Content();

        $this->content = $objValidation->validatesFormsContent($objContent);

        if (isset($this->content)) {
            $this->content['result'] = 'Ошибка добавления статьи';
        } else {
            $this->content = ['result' => 'Новость успешно добавлена'];

            if ($this->appConfig['database'] === db::FILES) {
                $objNewsModel->addContent($objContent, $this->database);
            } else {
                $objNewsModel->writeData($objContent, db::NEWS);
            }

        }

        $this->view->render('content-action', 'Добавление новости', $this->content);
    }

    /**
     * Результат редактирования новости и сохранение в базу данных
     *
     * Валидация полей
     */
    public function getResultEditNews(int $id): void
    {
        $objValidation = new Validations();
        $objNewsModel = new NewsModel();
        $objContent = new Content();

        $this->content = $objValidation->validatesFormsContent($objContent);

        if (isset($this->content)) {
            $this->content['result'] = 'Ошибка редактирования новости';
        } else {
            $this->content = ['result' => 'Новость успешно отредактирована'];

            if ($this->appConfig['database'] === db::MYSQL) {
                $objNewsModel->updateData($objContent, db::NEWS, $id);
            } else {
                $objNewsModel->editContent($objContent, $id, $this->database);
            }

        }

        $this->view->render('content-action', 'Редактирование новости', $this->content);
    }
}