<?php

namespace database\seeders;

class SeederSubCatalogData
{
    public function installDefaultSeeders(): string
    {
        return "INSERT INTO sub_catalog (name)" .
            "VALUES " .
            "('Цельнокомпозитная')," .
            "('Вратаря')," .
            "('Игрока')," .
            "('Композитная')," .
            "('Спортивная')," .
            "('Женская')," .
            "('Мужская')," .
            "('Тренера')," .
            "('Хоккейная');";
    }

    public function generate(int $count = null): array
    {
        return [];
    }
}

return new SeederSubCatalogData();
