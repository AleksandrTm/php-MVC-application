<?php

namespace Core;


use Exception;
use config\Paths;

/**
 *
 */
class Model
{
    protected array $allData;

    /**
     * $path: путь до нужного каталога
     */
    function readData($path): array
    {
        try {
            if ($dir = opendir($path)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == '.' || $file == '..' || $file == '.gitkeep') {
                        continue;
                    }
                    $this->allData[$file] = file_get_contents($path . $file);
                }
            }
        } catch (Exception $e) {
            var_dump($e);
        } finally {
            closedir($dir ?? null);
        }
        return $this->allData;
    }
}