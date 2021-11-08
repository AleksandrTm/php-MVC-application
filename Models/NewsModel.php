<?php

namespace Models;

use Core\Pagination;
use Enums\Database as db;
use Throwable;

class NewsModel extends ContentModel
{
    /** Новости за 24 часа */
    public array $currentLastDayNews = [];

    /**
     * Получаем новости за последний 24 часа
     */
    public function getNewsFromTheLastDay(): array
    {
        if ($this->appConfig['database'] === db::MYSQL) {
            $currentTime = date(("Y-m-d H:i:s"));
            $pagination = new Pagination(db::NEWS);

            $this->resultQuery = $this->mysqlConnect->query(
                "SELECT n.id, n.title, n.text, u.full_name, n.date FROM " .
                "news n JOIN users u on u.user_id = n.user_id WHERE n.date > '$currentTime' " .
                "ORDER BY date DESC LIMIT " . $this->appConfig['number_record_page'] .
                " OFFSET $pagination->beginWith");

            while ($content = $this->resultQuery->fetch_assoc()) {
                $this->currentLastDayNews[] = [
                    'id' => $content['id'],
                    'title' => $content['title'],
                    'text' => $this->getShortText($content['text']),
                    'author' => $content['full_name'],
                    'date' => $content['date']
                ];
            }
        } else {
            /** Количество секунд в сутках */
            $secondsDay = 24 * 60 * 60;

            /** Текущее unix время */
            $currentUnixTime = time();

            /** Получаем все новости из базы с кратким содержанием */
            $this->getDataAllContent(db::NEWS);

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
        }

        return $this->currentLastDayNews;
    }
}