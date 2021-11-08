<?php

namespace database\seeders;

use Core\Generators;

class SeederNews
{
    public function installDefaultSeeders(): string
    {
        return "INSERT INTO news (title, text, user_id, date)" .
            "VALUES ('Тестовая новость', " .
            "'text text text text text text text text text text text " .
            "text text text text text text text text text text text " .
            "text text text text text text text text text text text'," .
            "'1', '2022-05-10')";
    }

    public function generate(int $count): array
    {
        $arr = [];
        $obj = new Generators();

        for ($i = 1; $i <= $count; $i++) {
            $title = "Сгенерированная новость № $i";
            $text = "text text text text text text text text text text text " .
                "text text text text text text text text text text text " .
                "text text text text text text text text text text text";
            $userId = 1;
            $data = $obj->generatesDate();

            $arr[] = "INSERT INTO news (title, text, user_id, date)" .
                "VALUES ('$title', '$text','$userId', '$data');";
        }

        return $arr;
    }
}

return new SeederNews();
