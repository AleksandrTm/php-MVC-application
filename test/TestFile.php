<?php

namespace Localsite\test;
include_once "../config/ConfigPaths.php";
include_once "../src/File.php";

use Localsite\src\File;

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
        File::addUser("Aleksandr", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-1900", "доп. инфа");

        File::addUser("Александр", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-2010", "доп. инфа");

        File::addUser("Aleksandr", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-2100", "доп. инфа");
    }

    /**
     * Вывод всех пользоваталей из файловой базы данных
     */
    static function testViewsUsers()
    {
        var_dump(File::viewsUsers());
    }

    /**
     * id последнего пользователя
     */
    static function testIdUsers()
    {
        var_dump(File::idUser());
    }
}

//TestFile::testFIleAddUser();
TestFile::testViewsUsers();
//TestFile::testIdUsers();