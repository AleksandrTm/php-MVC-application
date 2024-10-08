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
            "`vendor_code`  varchar(20)     NULL DEFAULT NULL," .
            "`catalog`      int             NULL," .
            "`sub_catalog`  int             NULL," .
            "`brand`        int             NULL," .
            "`model`        varchar(255)    NULL DEFAULT NULL," .
            "`size`         int             NULL," .
            "`color`        int             NULL," .
            "`orientation`  varchar(1)      NULL DEFAULT NULL," .
            "FOREIGN KEY (catalog) REFERENCES catalog (id)," .
            "FOREIGN KEY (sub_catalog) REFERENCES sub_catalog (id)," .
            "FOREIGN KEY (brand) REFERENCES brand (id)," .
            "FOREIGN KEY (size) REFERENCES size (id)," .
            "FOREIGN KEY (color) REFERENCES color (id)" .
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
