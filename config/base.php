<?php

use Core\Model;

/**
 * Конфигурация использования Базы данных SQL или Файлов
 */
return [
    'sqlBase' => Model::getArraySQL(),
    'fileBase' => Model::getArrayFile()
];