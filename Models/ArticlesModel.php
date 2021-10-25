<?php

namespace Models;

use config\Paths;
use Core\Model;

class ArticlesModel extends Model
{
    protected array $articlesInfo = [];

    /**
     * Получаем данные всех статей из базы данных и заносим в массив по ключам
     */
    function getDataAllArticles(): array
    {
        $this->getAllDataFromDatabase(Paths::DIR_BASE_ARTICLES);

        foreach ($this->allData as $articlesId => $articlesData) {

            /** Разбиваем по строкам и заносим в переменные */
            list($titleArticles, $textArticles, $author, $date) = explode("\n", $articlesData);

            /** Заносим данные в ассоциативный массив */
            $this->articlesInfo[$articlesId] = [
                'titleArticles' => $titleArticles,
                'textArticles' => $textArticles,
                'author' => $author,
                'date' => $date,
            ];
        }
        return $this->articlesInfo;
    }
}