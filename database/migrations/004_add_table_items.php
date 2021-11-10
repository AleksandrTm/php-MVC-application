<?php

/**
 * Таблица users
 */
class AddTableItems
{
    /**
     * Создание таблицы
     */
    public function up(): string
    {
        return "CREATE TABLE `items`" .
            "(`id`          int             PRIMARY KEY AUTO_INCREMENT," .
            "`name`         varchar(255)    NOT NULL," .
            "`vendor_code`  varchar(255)    NULL," .
            "`catalog`      varchar(255)    NULL," .
            "`sub_catalog`  varchar(255)    NULL," .
            "`brand`        varchar(255)    NULL," .
            "`model`        varchar(255)    NULL," .
            "`grip`         varchar(255)    NULL," .
            "`size`         varchar(255)    NULL," .
            "`color`        varchar(255)    NULL" .
            ") DEFAULT CHARSET = utf8;";
    }

    /**
     * Удаление таблицы
     */
    public function down(): string
    {
        return "DROP TABLE `items`";
    }
}

return new AddTableItems();
