<?php

namespace database\seeders;

class SeederSizeData
{
    public function installDefaultSeeders(): string
    {
        return "INSERT INTO size (name)" .
            "VALUES ('SR'), /* Взрослые */" .
            "('INT'), /* Переходная */" .
            "('JR'), /* Юниорские */" .
            "('YTH'), /* Детская */" .
            "('XS')," .
            "('X')," .
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
