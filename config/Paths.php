<?php

namespace config;

/**
 * ConfigPaths: хранит пути до директорий
 */
class Paths
{
    # Путь до базы данных пользователей
    const DIR_BASE_USERS = "../database/users/";
    # Путь до views
    const DIR_VIEWS = "../views/";
    # Путь до src
    const DIR_CORE = "../Core/";
}

/**
 * НОВАЯ РЕАЛИЗАЦИЯ, следующий этап
 * НА ТЕКУЩИЙ МОМЕНТ НЕ ИСПОЛЬЗУЕТСЯ!!!
 */
function newPaths(): array
{
    return [
    # Путь до базы данных пользователей
    'DIR_BASE_USERS' => __DIR__ . '/../database/users/',
    # Путь до views
    'DIR_VIEWS' => __DIR__ . '/../views/',
    # Путь до src
    'DIR_SRC' => __DIR__ . '../src/'
];
}
