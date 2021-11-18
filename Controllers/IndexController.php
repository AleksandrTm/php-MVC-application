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
//        foreach ($this->params as $param) {
//            $this->content[$param] = htmlentities(strip_tags($_POST[$param]));
//        }
        $catalog = htmlentities(strip_tags($_POST['catalog']));
        $subCatalog = htmlentities(strip_tags($_POST['subCatalog']));
        $brand = htmlentities(strip_tags($_POST['brand']));
        $size = htmlentities(strip_tags($_POST['size']));
        $color = htmlentities(strip_tags($_POST['color']));


//        foreach ($this->content as $param) {
//            if (!($param === 'NULL' || ctype_digit($param))) {
//                $this->content['error'] = true;
//                $this->view->render('index', 'Главная страница', $this->content);
//                return;
//            }
//        }

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
            $_POST['color'] ?? 'NULL'
        );

//        $this->content['items'] = $this->items->getItems(
//            $this->itemsPost->getCatalog() ?? 'NULL',
//            $this->itemsPost->getSubCatalog() ?? 'NULL',
//            $this->itemsPost->getBrand() ?? 'NULL',
//            $this->itemsPost->getSize() ?? 'NULL',
//            $this->itemsPost->getColor() ?? 'NULL');

        $this->view->render('index', 'Главная страница', $this->content);
    }
}