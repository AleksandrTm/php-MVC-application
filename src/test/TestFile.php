<?php
namespace src\test;

use src\Model\Users;

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
        Users::addUser("Aleksandr", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-1900", "доп. инфа");

        Users::addUser("Александр", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-2010", "доп. инфа");

        Users::addUser("Aleksandr", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-2100", "доп. инфа");
    }

    /**
     * Вывод всех пользоваталей из файловой базы данных
     * НЕ КОРРЕКТНО РАБОТАЕТ!!! РАЗОБРАТСЯ В ПРИЧИНЕ!!!
     */
    static function testViewsUsers()
    {
        var_dump(Users::viewsUsers());
    }

    /**
     * id последнего пользователя
     */
    static function testIdUsers()
    {
        var_dump(Users::idUser());
    }
}

//TestFile::testFIleAddUser();
TestFile::testViewsUsers();
//TestFile::testIdUsers();