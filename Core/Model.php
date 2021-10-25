<?php

namespace Core;

use Exception;
use config\Paths;

/**
 * Базовая модель
 */
class Model
{
    protected array $allData = [];

    /**
     * Получает все данные с указанной базы данных, и отдаёт их в массиве
     */
    function getAllDataFromDatabase($path): array
    {
        try {
            if ($dir = opendir($path)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == '.' || $file == '..') {
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

    /**
     * Проверка наличия записи в базе по id
     */
    function checksExistenceRecord($base, int $id): bool
    {
        return file_exists($base . $id);
    }

    /**
     * Получаем последний id записи в указанной базе данных
     */
    function getLastId(string $type): int
    {
        $this->getAllDataFromDatabase($type);
        $data = array_keys($this->allData);
        rsort($data);
        return (int)array_shift($data);
    }

    /**
     * Удаление по id
     */
    function deletesContent(int $id, string $typeBase): void
    {
        try {
            unlink($typeBase . $id);
        } catch (Exception $e) {
            var_dump($e);
        }
    }
}