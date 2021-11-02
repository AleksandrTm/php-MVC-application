<?php

namespace Models;

use Enums\Database as db;

class ArticlesModel extends ContentModel
{
    protected array $articlesData = [];

    /**
     * Получаем данные всех статей из базы данных и заносим в массив по ключам
     */
    public function getDataAllArticles(): array
    {
        /** Выводим все статьи с кратким содержанием */
        $this->articlesData = $this->getDataAllContent(db::ARTICLES);


        if ($this->appConfig['database'] === db::MYSQL) {
            while ($content = $this->resultQuery->fetch_assoc()) {
                $this->articlesData[] = [
                    'id' => $content['article_id'],
                    'title' => $content['title'],
                    'text' => $this->getShortText($content['text']),
                    'author' => $content['user_id'],
                    'date' => $content['date']
                ];
            }
        }

        return $this->articlesData;
    }
}