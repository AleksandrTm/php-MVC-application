<?php

namespace Enums;

class Content
{
    const TITLE_ARTICLE = "Заголовок контента";
    const TEXT = "CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT";
    const AUTHOR = "Aleksandr";
    const TYPE = [
        'ARTICLES' => 'articles',
        'NEWS' => 'news',
        'USERS' => 'users',
    ];

    /**
     * Количество символов для краткой новости или статьи
     */
    const SHORT_TEXT = 100;
}