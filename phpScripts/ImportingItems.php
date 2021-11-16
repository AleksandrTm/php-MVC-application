<?php

namespace phpScripts;

use Enums\Paths;
use Core\Connections\MySQLConnection;
use mysqli;

include_once '../Core/Autoload.php';

/**
 * Импорт товаров из файлов в базу данных по параметрам
 */
class ImportingItems
{
    private string $path;
    private mysqli $connection;

    private array $tables = ['brand' => 'brand', 'size' => 'size', 'catalog' => 'catalog',
        'subCatalog' => 'sub_catalog', 'color' => 'color'];

    /**
     * Параметры товаров
     */
    private array $brand;
    private array $subCatalog;
    private array $catalog;
    private array $size;
    private array $color;

    private string $regCode = "\w*?\d{5,}";
    private string $regBrand = "";

    private array $allItems;

    private ?array $item = null;

    public function __construct()
    {
        $this->path = Paths::DIR_RESOURCE;
        $this->connection = MySQLConnection::getInstance()->getConnection();
        $this->fillingData();

//        $str = "Гамаши хоккейные SR Вашингтон т-син/крас/бел";
        $str = "Коньки Reebok детс. раздвижные Expandable (H449007100)";
//
        print "исходная : " . $str . "\n";
//        $str = $this->lookingForBrands($str);
//        print "без бренда : " . $str . "\n";
//        $str = $this->lookingForVendorCode($str);
//        print "без кода : " . $str . "\n";
//        $str = $this->lookingForCatalog($str);
//        print "без catalog : " . $str . "\n";
//        $str = $this->lookingForSubCatalog($str);
//        print "без subCatalog : " . $str . "\n";
        $str = $this->lookingForSize($str);
        print "без размера : " . $str . "\n";
//
//        $name = $this->item['catalog']['name'] . " " . $str;
//
//        $this->sendItemToDatabase($name, $this->item['vendorCode'], $this->item['catalog']['id'],
//            $this->item['subCatalog']['id'], $this->item['brand']['id']);


//        $this->parsesData();
        var_dump($this->item);
    }

    /**
     * Данные из базы по параметрам товаров ( проходит по всем таблицам с параметрами )
     *
     * Из базы в массивы для дальнейшей работы
     */
    private function fillingData(): void
    {
        foreach ($this->tables as $key => $table) {
            $resultQuery = $this->connection->query("SELECT * FROM $table;");
            while ($data = $resultQuery->fetch_assoc()) {
                $this->{$key}[] = $data;
            }
        }
    }

    /**
     * Отправляет товар в базу с параметрами
     */
    private function sendItemToDatabase(
        string $name,
        string $vendorCode = '',
        int    $catalog = null,
        int    $subCatalog = null,
        int    $brand = null,
        string $model = '',
        int    $size = null,
        int    $color = null,
        string $orient = ''
    ): void
    {
        $catalog = $catalog ?? 'NULL';
        $subCatalog = $subCatalog ?? 'NULL';
        $brand = $brand ?? 'NULL';
        $size = $size ?? 'NULL';
        $color = $color ?? 'NULL';
        $this->connection->query("INSERT INTO items (name, vendor_code, catalog, sub_catalog, brand, model, size, color, orientation) " .
            "VALUES ('$name', '$vendorCode', $catalog, $subCatalog, $brand, '$model', $size, $color, '$orient');");
    }

    /**
     * Осуществляет поиск в строке наличие Цвета
     */
    private function lookingForColor(string $string): string
    {
        foreach ($this->color as $value) {
            $string = mb_strtolower($string);
            $color = mb_strtolower($value['name']);
            $res = preg_match("/({$color})/", $string, $matches);
            if ($res) {
                $string = preg_replace("/({$color})/", "", $string);
                $string = preg_replace('/\s{2,}/im', " ", $string);
                $this->item['color'] = ['id' => $value['id'], 'name' => $value['name']];
            }
        }

        return $string;
    }

    /**
     * Осуществляет поиск в строке наличие Размера
     */
    private function lookingForSize(string $string): string
    {
        foreach ($this->size as $value) {
            $string = mb_strtolower($string);
            $size = mb_strtolower($value['name']);

            $res = preg_match("/({$size}(^\S+))/", $string, $matches);
// |взросл|перех|юниор|детс
            if ($size === 'yth' && !$res) {
                $res = preg_match("/(детс)/", $string, $matches);
                $size = 'детс';
            }

            if ($res) {
                $string = preg_replace("/({$size}\S+)/", "", $string);
                $string = preg_replace('/\s{2,}/im', " ", $string);
                $this->item['size'] = ['id' => $value['id'], 'name' => $value['name']];

                return $string;
            }
        }

        return $string;
    }

    /**
     * Осуществляет поиск в строке наличие Бренда
     */
    private function lookingForBrands(string $string): string
    {
        foreach ($this->brand as $value) {
            $brand = $value['name'];
            $res = preg_match("/({$brand})/", $string, $matches);

            if ($brand === 'Reebok' && !$res) {
                $res = preg_match("/(RBK)/", $string, $matches);
                $brand = 'RBK';
            }

            if ($res) {
                $string = preg_replace("/({$brand})/", "", $string);
                $string = preg_replace('/\s{2,}/im', " ", $string);
                $this->item['brand'] = ['id' => $value['id'], 'name' => $value['name']];

                return $string;
            }
        }

        return $string;
    }

    /**
     * Осуществляет поиск в строке наличие Каталога
     */
    private function lookingForCatalog(string $string): string
    {
        foreach ($this->catalog as $value) {
            $string = mb_strtolower($string);
            $catalog = mb_strtolower($value['name']);
            $catalogSubStr = mb_substr($catalog, 0, -1);
            $res = preg_match("/({$catalogSubStr})/", $string, $matches);
            if ($res) {
                $string = preg_replace("/({$catalogSubStr}\S+)/", "", $string);
                $string = preg_replace('/\s{2,}/im', " ", $string);
                $this->item['catalog'] = ['id' => $value['id'], 'name' => $value['name']];
            }
        }

        return $string;
    }

    /**
     * Осуществляет поиск в строке наличие Под Каталога
     */
    private function lookingForSubCatalog(string $string): string
    {
        foreach ($this->subCatalog as $value) {
            $string = mb_strtolower($string);
            $subCatalog = mb_strtolower($value['name']);
            $subCatalogSubStr = mb_substr($subCatalog, 0, -3);
            $res = preg_match("/({$subCatalogSubStr})/i", $string, $matches);
            if ($res) {
                $string = preg_replace("/({$subCatalogSubStr}\S+)/", "", $string);
                $string = preg_replace('/\s{2,}/im', " ", $string);
                $this->item['subCatalog'] = ['id' => $value['id'], 'name' => $value['name']];
            }
        }

        return $string;
    }

    /**
     * Осуществляет поиск в строке наличие Артикла товара
     */
    private function lookingForVendorCode(string $string): string
    {
        $res = preg_match("/({$this->regCode})/", $string, $matches);
        if ($res) {
            $string = preg_replace("/({$this->regCode})/", "", $string);
            $string = preg_replace('/\s{2,}/im', " ", $string);
            $this->item['vendorCode'] = $matches[0] ?? null;
        }

        return $string;
    }

    /**
     * Список всех файлов в каталоге
     */
    private function getAllFiles(): array
    {
        return array_diff(scandir($this->path), array('..', '.'));
    }

    /**
     * Парсит строки по фильтрам из базы данных
     */
    public function parsesData(): void
    {
        $files = $this->getAllFiles();

        if (empty($files)) {
            print "Список пуст \n";
            return;
        }
        foreach ($files as $file) {
            $file = file_get_contents($this->path . $file);
            $file = preg_replace('/([")( ])/im', ' ', $file);
            $file = preg_replace('/[ ]{2,}/im', ' ', $file);

            // разбиваем файл на массив по строчно
            $allItems = explode("\n", $file);
            // удаляем пустые строки ( последняя пустая )
            $allItems = array_diff($allItems, array(''));
            // удаляем пробелы в начале и конце значений
            $this->allItems = array_map('trim', $allItems);

            foreach ($this->allItems as $item) {
                $item = $this->lookingForBrands($item);
                $item = $this->lookingForCatalog($item);
                $item = $this->lookingForVendorCode($item);
                $item = $this->lookingForSubCatalog($item);
                $item = $this->lookingForSize($item);

                $vendorCode = $this->item['vendorCode'] ?? null;
                $brand = $this->item['brand']['id'] ?? null;
                $catalog = $this->item['catalog']['id'] ?? null;
                $subCatalog = $this->item['subCatalog']['id'] ?? null;
                $size = $this->item['size']['id'] ?? null;

                $name = $item;
                $this->sendItemToDatabase($name, "$vendorCode", $catalog, $subCatalog, $brand, 'null', $size);

                $this->item = null;
            }
        }
    }
}

(new ImportingItems());
