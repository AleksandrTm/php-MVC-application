<?php

/**
 * Таблица news
 */
class News
{
    /**
     * Создание таблицы
     */
    static function up(): string
    {
        return "CREATE TABLE `news`" .
            "(`news_id` int PRIMARY KEY AUTO_INCREMENT," .
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
    static function rollback(): string
    {
        return "DROP TABLE `news`";
    }
}

return new News;