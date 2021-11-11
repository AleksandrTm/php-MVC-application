<?php

/**
 * Таблица users
 */
class AddTableSubCatalogItems
{
    /**
     * Создание таблицы
     */
    public function up(): string
    {
        return "CREATE TABLE `sub_catalog`" .
            "(`id`          int             PRIMARY KEY AUTO_INCREMENT," .
            "`name`         varchar(255)    NOT NULL" .
            ") DEFAULT CHARSET = utf8;";
    }

    /**
     * Удаление таблицы
     */
    public function down(): string
    {
        return "DROP TABLE `sub_catalog`";
    }
}

return new AddTableSubCatalogItems();
