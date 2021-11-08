<?php

namespace Models;

use Core\Pagination;
use Enums\Database as db;

class ArticlesModel extends ContentModel
{
    protected array $articlesData = [];

    /**
     * Получаем данные всех статей из базы данных и заносим в массив по ключам
     */
    public function getDataAllArticles(): array
    {
        $pagination = new Pagination(db::ARTICLES);

        if ($this->appConfig['database'] === db::MYSQL) {
            $this->resultQuery = $this->mysqlConnect->query(
                "SELECT a.id, a.title, a.text, u.full_name, a.date " .
                "FROM articles a JOIN users u on u.user_id = a.user_id " .
                "ORDER BY date DESC LIMIT " . $this->appConfig['number_record_page'] .
                " OFFSET $pagination->beginWith");

            while ($content = $this->resultQuery->fetch_assoc()) {
                $this->articlesData[] = [
                    'id' => $content['id'],
                    'title' => $content['title'],
                    'text' => $this->getShortText($content['text']),
                    'author' => $content['full_name'],
                    'date' => $content['date']
                ];
            }
        }

        return $this->articlesData;
    }
}