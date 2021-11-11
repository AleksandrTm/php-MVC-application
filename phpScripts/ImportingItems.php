<?php

namespace phpScripts;

use Enums\Paths;
use Core\Connections\MySQLConnection;
use mysqli;
use mysqli_result;

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

    private array $brand;
    private array $subCatalog;
    private array $catalog;
    private array $size;
    private array $color;

    public function __construct()
    {
        $this->path = Paths::DIR_RESOURCE;
        $this->connection = MySQLConnection::getInstance()->getConnection();
        $this->fillingData();
    }

    /**
     * Данные из базы по параметрам товаров
     *
     * Из базы в массивы для дальнейшей работы
     */
    private function fillingData()
    {
        foreach ($this->tables as $key => $table) {
            $resultQuery = $this->connection->query("SELECT name FROM $table;");
            while ($data = $resultQuery->fetch_assoc()) {
                $this->{$key}[] = $data['name'];
            }
        }
    }

    /**
     * Разбивает файл на массив без
     */
    public function parsesData(): void
    {
        $files = $this->getAllFiles();
        $allItems = [];

        if (empty($files)) {
            print "Список пуст \n";
        } else {
            foreach ($files as $file) {
                $file = file_get_contents($this->path . $file);
                $file = str_replace('"', '', $file);
                $file = preg_replace('/("\')/i', '', $file);
                $file = preg_replace('/[ ]{2,}/im', ' ', $file);
                $file = preg_replace('/[( ]{2,}/im', '(', $file);

//             $file = preg_replace('/([(])([A-Z]{,2})([0-9]{,2})([)])/im', '', $file);
//             $file = preg_replace('/[a-zA-Z]/im', '', $file);
//             $file = preg_replace('/[ ]{2,}/im', ' ', $file);

                // разбиваем файл на массив по строчно
                $allItems = explode("\n", $file);
                // удаляем пустые строки ( последняя пустая )
                $allItems = array_diff($allItems, array(''));
                // удаляем пробелы в начале и конце значений
                $allItems = array_map('trim', $allItems);


                foreach ($allItems as $item) {
//                    print $item . "\n";
                }
//                var_dump($this->resultQuery->fetch_assoc());
//                while ($brand = $this->resultQuery->fetch_assoc()) {
//                    $reg = $brand['name'];
//                        preg_match("/$reg/i", $item, $test);
//                        print $test;
//                }
//                foreach ($result as $brand){
//                    echo $brand['name'] . "\n";
//                }
//                foreach ($allItems as $item) {
//                    preg_match("/([(])([A-Z0-9]*([)]))/im", $item, $test);

//                    if (!empty($test[0])) {
//                        $this->item[] = $test[0];
//                    }
//                }
            }
        }

//        var_dump($allItems);
//        var_dump($this->item);
    }

    /**
     * Список всех файлов в каталоге
     */
    private function getAllFiles(): array
    {
        return array_diff(scandir($this->path), array('..', '.'));
    }

}

(new ImportingItems())->parsesData();
