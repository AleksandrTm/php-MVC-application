<?php

include_once "../config/config.php";
include_once "../src/File.php";


/**
 * Тестирование функции addUser.
 * Создание файла с id пользователя.
 * Запись в файл по id, информацию о пользователе.
 */
function testFIle()
{
    addUser("Aleksandr", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-1900", "доп. инфа");

    addUser("Александр", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-2010", "доп. инфа");

    addUser("Aleksandr", "password", "admin@localsite.ru", "Гребенников Александр Сергеевич", "8-12-2100", "доп. инфа");
}


testFIle();