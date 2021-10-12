<?php

include_once "../config/Config.php";
include_once "../src/File.php";

use Localsite\src\File as Files;

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
        Files::addUser("Aleksandr", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-1900", "доп. инфа");

        Files::addUser("Александр", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-2010", "доп. инфа");

        Files::addUser("Aleksandr", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-2100", "доп. инфа");
    }
}

TestFile::testFIleAddUser();