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

        return $this->articlesData;
    }
}