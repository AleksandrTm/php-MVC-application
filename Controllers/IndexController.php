<?php

namespace Controllers;

use Core\Controller;
use Models\ItemsModel;

/**
 * Главная страница сайта по URI /
 */
class IndexController extends Controller
{
    private ItemsModel $items;
    private array $content;

    public function __construct()
    {
        parent::__construct();
        $this->items = new ItemsModel();

        $this->content['catalog'] = $this->items->getList('catalog');
        $this->content['subCatalog'] = $this->items->getList('sub_catalog');
        $this->content['brand'] = $this->items->getList('brand');
        $this->content['size'] = $this->items->getList('size');
        $this->content['color'] = $this->items->getList('color');
    }

    public function getIndexPage(): void
    {

        $this->view->render('index', 'Главная страница', $this->content);
    }

    public function getIndexPagePost(): void
    {
        $this->content['items'] = $this->items->getItems($_POST['catalog'],
            $_POST['subCatalog'] ?? 'NULL',
            $_POST['brand'] ?? 'NULL',
            $_POST['size'] ?? 'NULL',
            $_POST['color'] ?? 'NULL');

        $this->view->render('index', 'Главная страница', $this->content);
    }
}