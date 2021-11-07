<?php

namespace Enums;

class Database
{
    const MYSQL = "mysql";
    const FILES = "files";

    /** Таблицы в базе данных */
    const USERS = 'users';
    const NEWS = 'news';
    const ARTICLES = 'articles';

    /** Папки хранения миграций и сидеров */
    const PATH_MIGRATES = '../database/migrations/';
    const PATH_SEEDERS = '../database/seeders/';

    /** путь до конфигурации базы данных */
    const PATH_DATABASE = "../config/database.php";
}