<?php

/**
 * Таблица users
 */
class AddTableBrand
{
    /**
     * Создание таблицы
     */
    public function up(): string
    {
        return "CREATE TABLE `brand`" .
            "(`id`          int             PRIMARY KEY AUTO_INCREMENT," .
            "`name`         varchar(255)    NOT NULL UNIQUE" .
            ") DEFAULT CHARSET = utf8;";
    }

    /**
     * Удаление таблицы
     */
    public function down(): string
    {
        return "DROP TABLE `brand`";
    }
}

return new AddTableBrand();
