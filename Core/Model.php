<?php

namespace Core;


use config\Paths;
use Exception;

/**
 *
 */
class Model
{
    protected array $data;

    public function __construct()
    {
        $this->data();
    }

    function data()
    {
        try {
            if ($dir = opendir(Paths::DIR_BASE_USERS)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == '.' || $file == '..' || $file == '.gitkeep') {
                        continue;
                    }
                    $this->data[] = $file;
                }
            }
        } catch (Exception $e) {
            var_dump($e);
        } finally {
            closedir($dir ?? null);
        }
    }
}