<?php

/**
 * Таблица users
 */
class AddTableCatalogItems
{
    /**
     * Создание таблицы
     */
    public function up(): string
    {
        return "CREATE TABLE `catalog`" .
            "(`id`          int             PRIMARY KEY AUTO_INCREMENT," .
            "`name`         varchar(255)    NOT NULL" .
            ") DEFAULT CHARSET = utf8;";
    }

    /**
     * Удаление таблицы
     */
    public function down(): string
    {
        return "DROP TABLE `catalog`";
    }
}

return new AddTableCatalogItems();
