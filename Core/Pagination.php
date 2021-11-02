<?php

namespace Core;

use config\Paths;

/**
 * Разбитие по страницам
 *
 * Нужные проверки и расчёты для пагинации
 */
class Pagination
{
    private Model $model;
    private View $view;
    public int $currentPage;
    public int $countPage;
    public int $beginWith;
    private array $appConfig;

    public function __construct()
    {
        $this->model = new Model();
        $this->view = new View();
        $this->appConfig = include '../config/app.php';
    }

    public function run(): void
    {
        $limit = $this->appConfig['number_record_page'];

        $this->countPage = ceil($this->model->getTheNumberOfRecords(Paths::DIR_BASE_USERS) / $limit);

        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        if ($_GET['page'] > $this->countPage || !($_GET['page'] > 0)) {
            $this->view->render('page-404', 'Страница не найдена');
        }

        $this->currentPage = $_GET['page'];
        $this->beginWith = ($this->currentPage * $limit) - $limit;

        $_GET['countPage'] = $this->countPage;
    }
}