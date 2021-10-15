<?php

namespace Core;
/**
 * БАЗОВАЯ РАБОТА С ФАЙЛАМИ И БД
 *
 * ОТКРЫЛ ФАЙЛ / ЗАПРОС В БД -> ПЕРЕДАЛ В МАССИВ -> ОТДАЛ В НАСЛЕДНИКА
 */
class Model
{
    public function __construct()
    {
        /**
         * ОПРЕДЕЛЯЕМ БД ИЛИ ФАЙЛ НУЖЕН ПОТОМКУ, ОТДАЁМ ДАННЫЕ
         */
    }

    /**
     * ВОЗВРАЩАЕМ МАССИВ ДАННЫХ
     */
    static function getArraySQL(): array
    {
        return [];
    }
    
    /**
     * ВОЗВРАЩАЕМ МАССИВ ДАННЫХ
     */
    static function getArrayFile(): array
    {
        return [];
    }
}