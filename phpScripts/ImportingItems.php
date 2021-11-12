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

    private array $allItems;

    private array $items;

    public function __construct()
    {
        $this->path = Paths::DIR_RESOURCE;
        $this->connection = MySQLConnection::getInstance()->getConnection();
        $this->fillingData();
        $this->parsesData();
    }

    /**
     * Данные из базы по параметрам товаров
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
    private function sellToDatabaseItem(string $name, string $vendorCode = null, int $catalog = null, int $subCatalog = null, int $brand = null,
                                        string $model = null, int $size = null, int $color = null, string $orient = null)
    {

    }

    /**
     * Осуществляет поиск в строке наличие Бренда
     */
    private function lookingForBrands(string $string): array
    {
        $data = null;
        foreach ($this->brand as $value) {
            $res = preg_match("/({$value['name']})/", $string, $matches);
            if ($res) {
                $data['string'] = preg_replace("/({$value['name']})/", "", $string);
                $data['string'] = preg_replace('/[ ]{2,}/im', " ", $data['string']);
                $data['brand'] = ['id' => $value['id'], 'name' => $value['name']];
            }
        }

        return $data;
    }

    /**
     * Осуществляет поиск в строке наличие Цвета
     */
    private function lookingForColor()
    {

    }

    /**
     * Осуществляет поиск в строке наличие Категории
     */
    private function lookingForCatalog()
    {

    }

    /**
     * Осуществляет поиск в строке наличие Под Категории
     */
    private function lookingForSubCatalog()
    {

    }

    /**
     * Осуществляет поиск в строке наличие Размеров
     */
    private function lookingForSize()
    {

    }

    /**
     * Список всех файлов в каталоге
     */
    private function getAllFiles(): array
    {
        return array_diff(scandir($this->path), array('..', '.'));
    }

    /**
     * Разбивает файл на массив без
     */
    public function parsesData(): void
    {
        $files = $this->getAllFiles();

        if (empty($files)) {
            print "Список пуст \n";
        } else {
            foreach ($files as $file) {
                $file = file_get_contents($this->path . $file);

//                $file = preg_replace('/(")/i', ' ', $file);
//                $file = preg_replace('/[(]/im', ' ', $file);
//                $file = preg_replace('/[)]/im', ' ', $file);

                $file = preg_replace('/([")( ])/im', ' ', $file);
                $file = preg_replace('/[ ]{2,}/im', ' ', $file);

//             $file = preg_replace('/([(])([A-Z]{,2})([0-9]{,2})([)])/im', '', $file);
//             $file = preg_replace('/[a-zA-Z]/im', '', $file);

                // разбиваем файл на массив по строчно
                $allItems = explode("\n", $file);
                // удаляем пустые строки ( последняя пустая )
                $allItems = array_diff($allItems, array(''));
                // удаляем пробелы в начале и конце значений
                $this->allItems = array_map('trim', $allItems);


//                foreach ($this->allItems as $item) {
//                    var_dump($item);
//                    if (!empty($test[0])) {
//                        var_dump($test[0]);
//                    }
//                }


//var_dump($this->allItems);

//                foreach ($allItems as $item) {
//                    print $item . "\n";
//                }
//                var_dump($this->resultQuery->fetch_assoc());
//                while ($brand = $this->resultQuery->fetch_assoc()) {
//                    $reg = $brand['name'];
//                        preg_match("/$reg/i", $item, $test);
//                        print $test;
//                }
//                foreach ($result as $brand){
//                    echo $brand['name'] . "\n";
//                }
//                foreach ($this->allItems as $item) {
//                    preg_match("/[A-Z0-9]/im", $item, $test);
//                    preg_replace('/(")/i', '', $this->allItems);
//                    if (!empty($test[0])) {
//                        var_dump($test[0]);
//                    }
//                }
//                var_dump($this->allItems);
            }
        }
    }
}

(new ImportingItems());
