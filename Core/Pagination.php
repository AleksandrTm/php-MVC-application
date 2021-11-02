<?php

namespace Core;

use config\Paths;

/**
 * Разбитие по страницам
 *
 * Нужные проверки и расчёты для пагинации
 */
class Pagination extends Model
{
    private View $view;
    public int $currentPage;
    public int $countPage;
    public int $beginWith;
    protected string $table;

    public function __construct(string $table)
    {
        parent::__construct();
        $this->view = new View();
        $this->table = $table;
        $this->run();
    }

    public function run(): void
    {
        $limit = $this->appConfig['number_record_page'];

        $this->countPage = ceil($this->getTheNumberOfRecords($this->table) / $limit);


        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        if ($_GET['page'] > $this->countPage || !($_GET['page'] > 0)) {
            $this->view->render('page-404', 'Страница не найдена');
        }

        $this->currentPage = $_GET['page'];
        $this->beginWith = ($this->currentPage * $limit) - $limit;

        if ($this->countPage > 1) {
            $_GET['countPage'] = $this->countPage;
        } else {
            $_GET['countPage'] = null;
        }
    }
}