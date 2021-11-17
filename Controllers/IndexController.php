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

//    private Items $itemsPost;

    public function __construct()
    {
        parent::__construct();
        $this->items = new IndexModel();
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
        $catalog = htmlentities(strip_tags($_POST['catalog']));
        $subCatalog = htmlentities(strip_tags($_POST['subCatalog']));
        $brand = htmlentities(strip_tags($_POST['brand']));
        $size = htmlentities(strip_tags($_POST['size']));
        $color = htmlentities(strip_tags($_POST['color']));

        if (!($catalog === 'NULL' || ctype_digit($catalog)) ||
            !($subCatalog === 'NULL' || ctype_digit($subCatalog)) ||
            !($brand === 'NULL' || ctype_digit($brand)) ||
            !($size === 'NULL' || ctype_digit($size)) ||
            !($color === 'NULL' || ctype_digit($color))) {
            $this->content['error'] = true;
            $this->view->render('index', 'Главная страница', $this->content);
            return;
        }

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