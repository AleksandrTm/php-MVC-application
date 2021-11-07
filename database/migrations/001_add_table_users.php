<?php

/**
 * Таблица users
 */
class Users
{
    /**
     * Создание таблицы
     */
    static function up(): string
    {
        return "CREATE TABLE `users`" .
            "(`user_id`   int PRIMARY KEY AUTO_INCREMENT," .
            "`login`     varchar(50)  NOT NULL," .
            "`password`  varchar(100) NOT NULL," .
            "`email`     varchar(50)  NOT NULL," .
            "`full_name` varchar(50)  NOT NULL," .
            "`role`      varchar(10)  NOT NULL DEFAULT 'member'," .
            "`date`      date         NOT NULL," .
            "`about`     varchar(200)          DEFAULT 'информация отсутствует'" .
            ") DEFAULT CHARSET = utf8;";
    }

    /**
     * Удаление таблицы
     */
    static function down(): string
    {
        return "DROP TABLE `users`";
    }
}

return new Users;