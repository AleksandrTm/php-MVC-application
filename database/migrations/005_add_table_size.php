<?php

/**
 * Таблица users
 */
class AddTableSize
{
    /**
     * Создание таблицы
     */
    public function up(): string
    {
        return "CREATE TABLE `size`" .
            "(`id`          int             PRIMARY KEY AUTO_INCREMENT," .
            "`name`         varchar(255)    NOT NULL UNIQUE" .
            ") DEFAULT CHARSET = utf8;";
    }

    /**
     * Удаление таблицы
     */
    public function down(): string
    {
        return "DROP TABLE `size`";
    }
}

return new AddTableSize();
