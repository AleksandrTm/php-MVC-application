<?php

namespace Models;

use Core\Pagination;
use Enums\Database as db;

class NewsModel extends ContentModel
{
    protected static ?NewsModel $_instance = null;

    /**
     * Если объект не создан, создаем и отдаём
     * Если объект создан, передаем уже существующий
     */
    public static function getInstance(): NewsModel
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }
    /** Новости за 24 часа */
    protected array $currentLastDayNews = [];

    /**
     * Получаем новости за последний 24 часа
     */
    public function getNewsFromTheLastDay(): array
    {

        if ($this->appConfig['database'] === db::MYSQL) {

            $currentTime = date(("Y-m-d"));

            $test = $this->appConfig['number_record_page'];
            $pagination = new Pagination(db::NEWS);

            $this->resultQuery = $this->mysqlConnect->query("SELECT * FROM news WHERE date >= '$currentTime' LIMIT $test OFFSET $pagination->beginWith");


            while ($content = $this->resultQuery->fetch_assoc()) {
                $this->currentLastDayNews[] = [
                    'id' => $content['news_id'],
                    'title' => $content['title'],
                    'text' => $this->getShortText($content['text']),
                    'author' => $content['user_id'],
                    'date' => $content['date']
                ];
            }
        }

        if ($this->appConfig['database'] === db::FILES) {
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