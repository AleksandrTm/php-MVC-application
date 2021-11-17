<?php

namespace database\seeders;

class SeederSizeData
{
    public function installDefaultSeeders(): string
    {
        return "INSERT INTO size (name)" .
            "VALUES ('XS')," .
            "('M')," .
            "('L')," .
            "('XL')," .
            "('XXL');";
    }

    public function generate(int $count = null): array
    {
        return [];
    }
}

return new SeederSizeData();
