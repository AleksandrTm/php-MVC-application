<?php

namespace Controllers;

use Core\Controller;
use Entities\Items;
use Models\ItemsModel;

/**
 * Главная страница сайта по URI /
 */
class IndexController extends Controller
{
    private ItemsModel $items;
    private array $content;
//    private Items $itemsPost;

    public function __construct()
    {
        parent::__construct();
        $this->items = new ItemsModel();
//        $this->itemsPost = new Items();

        $this->content['catalog'] = $this->items->getList('catalog');
        $this->content['subCatalog'] = $this->items->getList('sub_catalog');
        $this->content['brand'] = $this->items->getList('brand');
        $this->content['size'] = $this->items->getList('size');
        $this->content['color'] = $this->items->getList('color');

//        $this->content['catalog'] = $this->itemsPost->getCatalog();
//        $this->content['subCatalog'] = $this->itemsPost->getSubCatalog();
//        $this->content['brand'] = $this->itemsPost->getBrand();
//        $this->content['size'] = $this->itemsPost->getSize();
//        $this->content['color'] = $this->itemsPost->getColor();
    }

    public function getIndexPage(): void
    {

        $this->view->render('index', 'Главная страница', $this->content);
    }

    public function getIndexPagePost(): void
    {
        $this->content['items'] = $this->items->getItems(
            $_POST['catalog'] ?? 'NULL',
            $_POST['subCatalog'] ?? 'NULL',
            $_POST['brand'] ?? 'NULL',
            $_POST['size'] ?? 'NULL',
            $_POST['color'] ?? 'NULL');

//        $this->content['items'] = $this->items->getItems(
//            $this->itemsPost->getCatalog() ?? 'NULL',
//            $this->itemsPost->getSubCatalog() ?? 'NULL',
//            $this->itemsPost->getBrand() ?? 'NULL',
//            $this->itemsPost->getSize() ?? 'NULL',
//            $this->itemsPost->getColor() ?? 'NULL');

        $this->view->render('index', 'Главная страница', $this->content);
    }
}