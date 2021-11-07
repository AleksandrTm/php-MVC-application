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
    const PATH_MIGRATES = '../database/migrates/';
    const PATH_SEEDERS = '../database/seeders/';
}