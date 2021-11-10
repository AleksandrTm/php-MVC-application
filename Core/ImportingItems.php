<?php

namespace Core;

use Enums\Paths;

/**
 * Импорт предметов из csv в базу данных
 */
class ImportingItems
{
    private string $path;
    public array $data;

    public function __construct()
    {
        $this->path = require_once Paths::DIR_RESOURCE;
    }

    /**
     * Парсит данные из файла
     */
    private function parsesData(string $file): void
    {

    }

    /**
     * Список всех файлов в каталоге
     */
    private function getAllFiles(): array
    {

        return [];
    }

}