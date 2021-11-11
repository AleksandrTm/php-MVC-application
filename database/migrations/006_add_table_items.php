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
            "`catalog`      int             NULL," .
            "`sub_catalog`  int             NULL," .
            "`brand`        varchar(255)    NULL," .
            "`model`        varchar(255)    NULL," .
            "`grip`         varchar(255)    NULL," .
            "`size`         varchar(255)    NULL," .
            "`color`        varchar(255)    NULL," .
            "FOREIGN KEY (catalog) REFERENCES catalog (id)," .
            "FOREIGN KEY (sub_catalog) REFERENCES sub_catalog (id)" .
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
