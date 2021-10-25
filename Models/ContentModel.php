<?php

namespace Models;

use Core\Model;

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
        // Обрезаем строку до 100 символов по дефолту
        $text = substr($text, 0, $number);

        // Ищем последний пробел и обрезаем по нему, добавляем троеточие
        return substr($text, 0, strrpos($text, ' ')) . "...";
    }

    /**
     * Получить контент по id
     */
    function getContentByID(int $id, string $typeContent)
    {
        /** Весь контент по типу ( новости, статьи, ...) */
        $content = $this->getDataAllContent($typeContent);

        /** Отдаём нужный контент по id */
        return $content[$id];
    }
}