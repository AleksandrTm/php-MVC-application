<?php

namespace Core;

use Enums\Paths;

include_once '../Core/Autoload.php';

/**
 * Импорт предметов из csv в базу данных
 */
class ImportingItems
{
    private string $path;
    public array $data;

    public string $name;
    public string $brand;
    public string $color;
    public string $code;
    public string $tempateCode = "([(])([A-Z0-9]{0,})([)])";

    public function __construct()
    {
        $this->path = Paths::DIR_RESOURCE;

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

//             $file =    preg_replace('/([(])([A-Z0-9]*([)]))/im', '', $file);


//             $file =    preg_replace('/[a-zA-Z]/im', '', $file);
//
//                $file = preg_replace('/[ ]{2,}/im', ' ', $file);

                // разбиваем файл на массив по строчно
                $allItems = explode("\n", $file);
                // удаляем пустые строки ( последняя пустая )
                $allItems = array_diff($allItems, array(''));
                // удаляем пробелы в начале и конце значений
                $allItems = array_map('trim', $allItems);

                foreach ($allItems as $item){
                    preg_match("/([(])([A-Z0-9]*([)]))/im", $item, $test);
                    if (!empty($test[0])) {
                        print_r($test[0] . "\n");
                    }
                }
            }
        }


//        var_dump($allItems);
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
