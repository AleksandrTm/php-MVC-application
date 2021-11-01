<?php

namespace Core;

use config\Paths;
use Enums\Content;

/**
 * Разбитией по страницам
 *
 * Нужные проверки и расчёты для пагинации
 */
class Pagination
{
    private int $quantityPerPage = Content::COUNT_CONTENT_PAGE;
    private string $database;
    private Model $model;
    private View $view;
    public int $currentPage;
    public int $countPage;

    public function __construct(string $database = Paths::DIR_BASE_NEWS)
    {
        $this->database = $database;
        $this->model = new Model();
        $this->view = new View();
    }

    public function run(): array
    {
        $this->currentPage = htmlspecialchars($_GET['page'] ?? $_GET['page'] = 1);
        $this->countPage = ceil($this->model->getTheNumberOfRecords($this->database) / $this->quantityPerPage);

        if (!ctype_digit($this->currentPage) || $_GET['page'] > $this->countPage) {
            $this->view->render('page-404', 'Страница не найдена');
        }

        $beginWith = ($this->currentPage * $this->quantityPerPage) - $this->quantityPerPage;

        return $this->model->getAllDataFromDatabase($this->database, $beginWith, $this->quantityPerPage);
    }

    public function getCountPage(){

    }
}