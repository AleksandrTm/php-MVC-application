<?php

namespace database\seeders;

use Core\Generators;

class SeederUsers
{
    public function installDefaultSeeders(): string
    {
        return "INSERT INTO users (login, password, email, full_name, date, role)" .
            "VALUES ('Aleksandr', '$2y$10\$HLqboUD5xDG75/WaClIKwu.yABfjRuQSbK0hOn22jkeE2ApSbLAuW'," .
            " 'admin@localsite.ru', 'Гребенников Александр Сергеевич', '1989-12-08', 'admin')," .
            "('Member', '$2y$10\$HLqboUD5xDG75/WaClIKwu.yABfjRuQSbK0hOn22jkeE2ApSbLAuW'," .
            "'member@localsite.ru', 'Фелипов Андрей Анатольевич', '1965-10-03', 'member');";
    }

    public function generate(int $count): array
    {
        $arr = [];
        $obj = new Generators();

        for ($i = 0; $i < $count; $i++) {
            $login = $obj->generatesEngText(10);
            $pass = password_hash("TestPass123", PASSWORD_DEFAULT);
            $email = $obj->generatesEngText(5) . "@user.ru";
            $fullName = "Сгенерированный Пользователь";
            $data = $obj->generatesDate(true);

            $arr[] = "INSERT INTO users (login, password, email, full_name, date) " .
                "VALUES ('$login', '$pass', '$email', '$fullName','$data');";
        }

        return $arr;
    }
}

return new SeederUsers();
