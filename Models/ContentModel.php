<?php

namespace Models;

use Core\Model;
use Exception;

class ContentModel extends Model
{
    protected array $allContentData = [];

    /**
     * Получаем данные всех новостей из базы данных и заносим в массив по ключам
     *
     * Флаг short, позволяет вывести краткий текст контента
     */
    function getDataAllContent(string $typeContent, bool $short = false): array
    {
        $this->getAllDataFromDatabase($typeContent);

        foreach ($this->allData as $idContent => $contentData) {

            /** Разбиваем по строкам и заносим в переменные */
            list($title, $text, $author, $date) = explode("\n", $contentData);

            /** Заносим данные в ассоциативный массив */
            $this->allContentData[$idContent] = [
                'title' => $title,
                /** При установленном $short = true, используем сокращенный текст контента */
                'text' => $short ? $this->getShortText($text) : $text,
                'author' => $author,
                'date' => $date,
            ];
        }
        return $this->allContentData;
    }

    /**
     * Возвращает короткий вариант переданного текста
     *
     * Обрезает по целое число на n-символов, добавляет троеточие
     */
    function getShortText(string $text, int $number = 100): string
    {
        /** Обрезать если длинна текста контента более $number символов */
        if (strlen($text) >= $number) {
            // Обрезаем строку до 100 символов по дефолту
            $text = substr($text, 0, $number);

            // Ищем последний пробел и обрезаем по нему, добавляем троеточие
            return substr($text, 0, strrpos($text, ' ')) . "...";
        }
        return $text;
    }

    /**
     * Получить контент по id
     */
    function getContentByID(int $id, string $typeContent): array
    {
        /** Весь контент по типу ( новости, статьи, ...) */
        $content = $this->getDataAllContent($typeContent);

        /** Отдаём нужный контент по id */
        return $content[$id];
    }

    function removesContent(string $database, int $id): bool
    {
        /** Проверка на существования контента */
        if ($this->checksExistenceRecord($database, $id)) {
            /** Удаляем контент, если такой имеется в базе данных по id */
            $this->removeFromTheDatabase($id, $database);

            return true;
        }
        return false;
    }

    /**
     * Добавление контента в базу данных
     */
    function addContent(object $object, string $database): void
    {
        if (empty($this->getLastId($database))) {
            $id = 1;
        } else {
            $id = ($this->getLastId($database) + 1);
        }
        $this->writeData($object, $id, $database);
    }

    /**
     * Редактирование контента
     */
    function editContent(object $object, int $id, string $database): void
    {
        if ($this->checksExistenceRecord($database, $id)) {
            $this->writeData($object, $id, $database);
        }
    }

    /**
     * Записывает данные в базу данных ( добавление или редактирование )
     */
    function writeData(object $object, int $id, string $database): void
    {
        $files = null;
        try {
            $files = fopen($database . $id, 'w');
            fwrite($files, $object->getTitle() . "\n");
            fwrite($files, $object->getText() . "\n");
            fwrite($files, $_SESSION['login'] . "\n");
            fwrite($files, date("d-m-Y H:i:s") . "\n");
        } catch (Exception $e) {
            var_dump($e);
        } finally {
            fclose($files);
        }
    }
}