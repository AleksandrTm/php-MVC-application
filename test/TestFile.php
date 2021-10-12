<?php

include_once "../config/config.php";
include_once "../src/File.php";

class TestFile
{
    function __construct()
    {
    }

    /**
     * Тестирование функции addUser.
     *
     * Создание файла с id пользователя.
     *
     * Запись в информации о пользователе в файл по id.
     *
     * !!! БЕЗ ВАЛИДАЦИИ !!!
     */
    static function testFIleAddUser()
    {
        addUser("Aleksandr", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-1900", "доп. инфа");

        addUser("Александр", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-2010", "доп. инфа");

        addUser("Aleksandr", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-2100", "доп. инфа");
    }
}

TestFile::testFIleAddUser();