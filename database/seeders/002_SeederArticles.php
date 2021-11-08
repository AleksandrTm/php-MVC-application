<?php

namespace database\seeders;

use Core\Generators;

class SeederArticles
{
    public function installDefaultSeeders(): string
    {
        return "INSERT INTO articles (title, text, user_id, date)" .
            "VALUES ('Тестовая статья', " .
            "'text text text text text text text text text text text " .
            "text text text text text text text text text text text " .
            "text text text text text text text text text text text'," .
            "'1', '2021-10-10')";
    }

    public function generate(int $count): array
    {
        $arr = [];
        $obj = new Generators();

        for ($i = 1; $i <= $count; $i++) {
            $title = "Сгенерированная статья № $i";
            $text = "text text text text text text text text text text text " .
                "text text text text text text text text text text text " .
                "text text text text text text text text text text text";
            $userId = 1;
            $data = $obj->generatesDate();

            $arr[] = "INSERT INTO articles (title, text, user_id, date)" .
                "VALUES ('$title', '$text','$userId', '$data');";
        }

        return $arr;
    }
}

return new SeederArticles();
