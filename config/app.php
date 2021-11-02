<?php

use Enums\Database as db;

/**
 * Конфигурация проекта
 */
return [
    /** Имя проекта */
    'name_project' => 'local-site',

    /** Тип базы данных для сайта */
    'database' => db::MYSQL,

    /** количество записей на страницу */
    'number_record_page' => 10,

    /** Количество символов на вывод краткого контента */
    'short_text' => 100,
];