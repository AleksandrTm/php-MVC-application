<?php

/**
 * Таблица users
 */
class AddTableColor
{
    /**
     * Создание таблицы
     */
    public function up(): string
    {
        return "CREATE TABLE `color`" .
            "(`id`          int             PRIMARY KEY AUTO_INCREMENT," .
            "`name`         varchar(255)    NOT NULL UNIQUE" .
            ") DEFAULT CHARSET = utf8;";
    }

    /**
     * Удаление таблицы
     */
    public function down(): string
    {
        return "DROP TABLE `color`";
    }
}

return new AddTableColor();
