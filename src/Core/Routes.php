<?php

namespace src\Core;

class Routes
{
    protected static ?Routes $_instance = null;

    private function __construct()
    {
        echo "Создание объекта \n";
    }

    /**
     * @return Routes
     * Если объект не создан, создаем и отдаём
     * Если объект создан, передаем уже существующий
     */
    public static function getInstance(): Routes
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * Переопределяем функцию клонирования
     * Убираем возможность клонировать существующий объект
     */
    function __clone()
    {
    }

    function Router()
    {
        echo "Перенаправляем: ОК \n";
    }

}

$newRouter = Routes::getInstance();
$newRouter->Router();
$newRouter2 = Routes::getInstance();
$newRouter2->Router();
$newRouter->Router();


echo "newRouter: " . spl_object_hash($newRouter) . "\n";
echo "newRouter2: " . spl_object_hash($newRouter2) . "\n";