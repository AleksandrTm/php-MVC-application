<?php

namespace Models;

use config\Paths;
use Core\Model;

class NewsModel extends Model
{
    /** Все новости в базе */
    protected array $allNewsData = [];

    /** Новости за 24 часа */
    protected array $currentLastDayNews = [];

    /**
     * Получаем данные всех новостей из базы данных и заносим в массив по ключам
     */
    function getDataAllNews(): array
    {
        $this->getAllDataFromDatabase(Paths::DIR_BASE_NEWS);

        foreach ($this->allData as $newsId => $newsData) {

            /** Разбиваем по строкам и заносим в переменные */
            list($titleNews, $textNews, $author, $date) = explode("\n", $newsData);

            /** Заносим данные в ассоциативный массив */
            $this->allNewsData[$newsId] = [
                'titleNews' => $titleNews,
                'textNews' => $textNews,
                'author' => $author,
                'date' => $date,
            ];
        }
        return $this->allNewsData;
    }

    /**
     * Получаем новости за последний 24 часа
     */
    function getNewsFromTheLastDay(): array
    {
        /** Все новости */
        $allNews = $this->getDataAllNews();

        /** Количество секунд в сутках */
        $secondsDay = 24 * 60 * 60;

        /** Текущее unix время */
        $currentUnixTime = time();

        /**
         * Алгоритм: Проходимся по массиву со всеми новостями.
         *
         * проверка по unix time, конвертируем дату в секунды,
         * проверяем разницу между текущим временем и созданным. Заносим в массив нужные.
         */
        foreach ($allNews as $idNews => $news) {
            if ($currentUnixTime - strtotime($news['date']) >= $secondsDay) {
                $this->currentLastDayNews[$idNews] = [
                    'titleNews' => $news['titleNews'],
                    'textNews' => $news['textNews'],
                    'author' => $news['author'],
                    'date' => $news['date'],
                ];
            };
        }
        return $this->currentLastDayNews;
    }
}