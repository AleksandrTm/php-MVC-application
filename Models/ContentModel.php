<?php

namespace Models;

use Core\Model;
use Enums\Database as db;
use Exception;

class ContentModel extends Model
{
    /**
     * Получить контент по id
     */
    public function getContentByID($id, string $database): array
    {
        $content = [];

        if ($this->appConfig['database'] === db::MYSQL) {
            $content[$id] = $this->mysqlConnect->query(
                "SELECT a.title, a.text, u.full_name as author, a.date " .
                " FROM $database a JOIN users u on u.user_id = a.user_id" .
                " WHERE id = '$id'")->fetch_assoc();
        } else {
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
            }
        }

        return $content[$id];
    }

    /**
     * Возвращает короткий вариант переданного текста
     *
     * Обрезает по целое число на n-символов, добавляет троеточие
     */
    public function getShortText(string $text, int $number = null): string
    {
        if ($number === null) {
            $number = $this->appConfig['short_text'];
        }

        /** Обрезать если длинна текста контента более $number символов */
        if (strlen($text) >= $number) {
            $text = substr($text, 0, $number);

            return substr($text, 0, strrpos($text, ' ')) . "...";
        }

        return $text;
    }


    public function removesContent(string $database, $id): bool
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            $this->mysqlConnect->query("DELETE FROM $database WHERE id = '$id'");
            return true;
        } else {
            /** Проверка на существования контента */
            if ($this->checksExistenceRecord($database, $id)) {
                /** Удаляем контент, если такой имеется в базе данных по id */
                $this->removeFromTheDatabase($id, $database);

                return true;
            }
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
        $this->writeData($object, $database, $id);
    }

    /**
     * Редактирование контента
     */
    public function editContent(object $object, int $id, string $database): void
    {
        if ($this->checksExistenceRecord($database, $id)) {
            $this->writeData($object, $database, $id);
        }
    }

    /**
     * Записывает данные в базу данных ( добавление или редактирование )
     */
    public function writeData(object $object, string $database, int $id = null): void
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            $title = $object->getTitle();
            $text = $object->getText();
            $userId = $_SESSION['id'];
            $date = date("Y-m-d H:i:s");

            $this->writeToDatabase("INSERT INTO $database (title, text, user_id, date)
                                        VALUES ('$title', '$text', '$userId', '$date')");
        } else {
            $files = null;
            try {
                $files = fopen($database . $id, 'w');
                fwrite($files, $object->getTitle() . "\n");
                fwrite($files, $object->getText() . "\n");
                fwrite($files, $_SESSION['fullName'] . "\n");
                fwrite($files, date("d-m-Y H:i:s") . "\n");
            } catch (Exception $e) {
                var_dump($e);
            } finally {
                fclose($files);
            }
        }
    }

    /**
     * Записывает данные в базу данных ( добавление или редактирование )
     */
    public function updateData(object $object, string $database, int $id): void
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            $title = $object->getTitle();
            $text = $object->getText();
            $userId = $_SESSION['id'];
            $date = date("Y-m-d H:i:s");

            $this->writeToDatabase("UPDATE $database " .
                "SET title = '$title', text = '$text', user_id = '$userId', date = '$date' " .
                "WHERE  id = '$id'");
        }
    }
}