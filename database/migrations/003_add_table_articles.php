<?php

/**
 * Таблица articles
 */
class Articles
{
    /**
     * Создание таблицы
     */
    static function up(): string
    {
        return "CREATE TABLE `articles`" .
            "(`article_id` int PRIMARY KEY AUTO_INCREMENT," .
            "`title`   varchar(50) NOT NULL," .
            "`text`    LONGTEXT    NOT NULL," .
            "`user_id` int         NOT NULL," .
            "`date`    DATETIME    NOT NULL," .
            "FOREIGN KEY (user_id) REFERENCES users (user_id)" .
            ") DEFAULT CHARSET = utf8;";
    }

    /**
     * Удаление таблицы
     */
    static function down(): string
    {
        return "DROP TABLE `articles`";
    }
}

return new Articles;
