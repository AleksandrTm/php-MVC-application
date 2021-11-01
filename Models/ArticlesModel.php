<?php

namespace Models;

use config\Paths;

class ArticlesModel extends ContentModel
{
    protected array $articlesData = [];

    /**
     * Получаем данные всех статей из базы данных и заносим в массив по ключам
     */
    public function getDataAllArticles(): array
    {
        /** Выводим все статьи с кратким содержанием */
        $this->articlesData = $this->getDataAllContent(true);

        return $this->articlesData;
    }
}