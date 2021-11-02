<?php

namespace Models;

use config\Paths;
use Core\Pagination;
use Enums\Database as db;

class NewsModel extends ContentModel
{
    /** Новости за 24 часа */
    protected array $currentLastDayNews = [];

    /**
     * Получаем новости за последний 24 часа
     */
    public function getNewsFromTheLastDay(): array
    {
        /** Получаем все новости из базы с кратким содержанием */
        $this->getDataAllContent(db::NEWS);

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
        foreach ($this->allContentData as $news) {
            if ($currentUnixTime - strtotime($news['date']) <= $secondsDay) {
                $this->currentLastDayNews[] = [
                    'id' => $news['id'],
                    'title' => $news['title'],
                    'text' => $news['text'],
                    'author' => $news['author'],
                    'date' => $news['date']
                ];
            }
        }

        return $this->currentLastDayNews;
    }
}