<?php

namespace Core;

use Enums\Database as db;

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
    public int $beginWith = 0;
    protected string $table;
    public int $count;

    public function __construct(string $table, $count = null)
    {
        parent::__construct();
        $this->view = new View();
        $this->table = $table;
        if (!is_null($count)) {
            $this->count = $count;
        }
        $this->run();
    }

    public function run(): void
    {

        $limit = $this->appConfig['number_record_page'];

        if ($this->table === 'items' || $this->table === db::NEWS && $this->appConfig['database'] === db::FILES) {
            $this->countPage = ceil($this->count / $limit);
            if ($this->count === 0) {
                return;
            }
        } else {
            $this->countPage = ceil($this->getTheNumberOfRecords($this->table) / $limit);
        }


        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }

        if ($this->getTheNumberOfRecords($this->table) === 0) {
            return;
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