<?php

namespace Controllers;

use Core\Controller;
use Models\IndexModel;

/**
 * Главная страница сайта по URI /
 */
class IndexController extends Controller
{
    private IndexModel $items;
    private array $content;
    private array $params = ['catalog', 'subCatalog', 'brand', 'size', 'color'];
    private array $selects = [];

    public function __construct()
    {
        parent::__construct();
        $this->items = new IndexModel();

        /** Обрабатываем фильтры select */
        foreach ($this->params as $param) {
            if ($param === 'subCatalog') {
                $this->content[$param] = $this->items->getList('sub_catalog');
                continue;
            }
            $this->content[$param] = $this->items->getList($param);
        }
    }

    public function getIndexPage(): void
    {
        $this->view->render('index', 'Главная страница', $this->content);
    }

    public function getIndexPagePost(): void
    {
        foreach ($this->params as $param) {
            $this->selects[] = htmlentities(strip_tags($_POST[$param]));
        }

        foreach ($this->selects as $select) {
            if (!($select === 'NULL' || ctype_digit($select))) {
                $this->content['error'] = true;
                $this->view->render('index', 'Главная страница', $this->content);
                return;
            }
        }

        $this->content['items'] = $this->items->getItems(
            $_POST['catalog'] ?? 'NULL',
            $_POST['subCatalog'] ?? 'NULL',
            $_POST['brand'] ?? 'NULL',
            $_POST['size'] ?? 'NULL',
            $_POST['color'] ?? 'NULL'
        );

        $this->view->render('index', 'Главная страница', $this->content);
    }
}