<?php

namespace database\seeders;

use Core\Generators;

class SeederBrandData
{
    public function installDefaultSeeders(): string
    {
        return "INSERT INTO brand (name)" .
            "VALUES ('Pallas')," .
            "('CCM')," .
            "('Другие')," .
            "('Reebok')," .
            "('BAUER')," .
            "('Tackla')," .
            "('Torspo')," .
            "('NBH')," .
            "('Easton')," .
            "('NITRO')," .
            "('Mad Guy')," .
            "('Jofa')," .
            "('OAKLEY')," .
            "('TPS')," .
            "('Montreal')," .
            "('TAC')," .
            "('Kosa')," .
            "('Salming')," .
            "('KOHO')," .
            "('Graf')," .
            "('Sher-Wood')," .
            "('OXDOG')," .
            "('Wall')," .
            "('Nike')," .
            "('Gufex')," .
            "('Vegum')," .
            "('Viking')," .
            "('GRIT');";
    }

    public function generate(int $count = null): array
    {
        return [];
    }
}

return new SeederBrandData();
