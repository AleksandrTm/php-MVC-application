<?php

namespace config;

use Enums\Database as db;

/**
 * Конфигурация сайта
 */
class App
{
    const NAME_PROJECT = "local-site";

    /** Какую базу данных использовать на сайте */
    const DATABASE = db::MYSQL;

    /** количество записей на страницу */
    const NUMBER_RECORD_PAGE = 10;

    /** Количество символов на вывод краткого контента */
    const SHORT_TEXT = 100;
}