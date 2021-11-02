<?php

namespace Models;

use Core\Model;
use Enums\Content;
use Enums\Database as db;
use Exception;

class ContentModel extends Model
{
    protected array $allContentData = [];

    /**
     * Получаем данные всех новостей из базы данных и заносим в массив по ключам
     *
     * Флаг short, позволяет вывести краткий текст контента
     */
    public function getDataAllContent(string $typeContent, bool $short = true): array
    {
        $this->getRecordsFromDatabase($typeContent, $this->appConfig['number_record_page']);

        if ($this->appConfig['database'] === db::FILES) {
            foreach ($this->allData as $idContent => $contentData) {
                list($title, $text, $author, $date) = explode("\n", $contentData);

                $this->allContentData[$idContent] = [
                    'id' => $idContent,
                    'title' => $title,
                    'text' => $short ? $this->getShortText($text) : $text,
                    'author' => $author,
                    'date' => $date
                ];
            }
        }
        return $this->allContentData;
    }

    /**
     * Возвращает короткий вариант переданного текста
     *
     * Обрезает по целое число на n-символов, добавляет троеточие
     */
    public
    function getShortText(string $text, int $number = Content::SHORT_TEXT): string
    {
        /** Обрезать если длинна текста контента более $number символов */
        if (strlen($text) >= $number) {
            $text = substr($text, 0, $number);

            return substr($text, 0, strrpos($text, ' ')) . "...";
        }

        return $text;
    }

    /**
     * Получить контент по id
     */
    public function getContentByID(int $id, string $database): ?array
    {
        $content = [];
        if ($this->checksExistenceRecord($database, $id)) {
            /** Весь контент по типу ( новости, статьи, ...) */
            $fullContentById = $this->getRecordsFromDatabase($database);

            foreach ($fullContentById as $idContent => $contentData) {
                list($title, $text, $author, $date) = explode("\n", $contentData);

                $content[$idContent] = [
                    'id' => $idContent,
                    'title' => $title,
                    'text' => $text,
                    'author' => $author,
                    'date' => $date
                ];
            }
            /** Отдаём нужный контент по id */
            return $content[$id];
        }
        return null;
    }

    public function removesContent(string $database, int $id): bool
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
    public function addContent(object $object, string $database): void
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
    public function editContent(object $object, int $id, string $database): void
    {
        if ($this->checksExistenceRecord($database, $id)) {
            $this->writeData($object, $id, $database);
        }
    }

    /**
     * Записывает данные в базу данных ( добавление или редактирование )
     */
    public function writeData(object $object, int $id, string $database): void
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