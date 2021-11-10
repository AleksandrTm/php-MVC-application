<?php

/**
 * Таблица users
 */
class TableUsers
{
    /**
     * Создание таблицы
     */
    public function up(): string
    {
        return "CREATE TABLE `users`" .
            "(`user_id`   int PRIMARY KEY AUTO_INCREMENT," .
            "`login`     varchar(50)  NOT NULL UNIQUE," .
            "`password`  varchar(100) NOT NULL," .
            "`email`     varchar(50)  NOT NULL UNIQUE," .
            "`full_name` varchar(50)  NOT NULL," .
            "`role`      varchar(10)  NOT NULL DEFAULT 'member'," .
            "`date`      date         NOT NULL," .
            "`about`     varchar(200)          DEFAULT 'информация отсутствует'" .
            ") DEFAULT CHARSET = utf8;";
    }

    /**
     * Удаление таблицы
     */
    public function down(): string
    {
        return "DROP TABLE `users`";
    }
}

return new TableUsers();
