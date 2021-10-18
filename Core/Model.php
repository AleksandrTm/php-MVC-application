<?php

namespace Core;
use config\Paths;

/**
 * БАЗОВАЯ РАБОТА С ФАЙЛАМИ И БД
 *
 * ОТКРЫЛ ФАЙЛ / ЗАПРОС В БД -> ПЕРЕДАЛ В МАССИВ -> ОТДАЛ В НАСЛЕДНИКА
 */
class Model
{
    function views(): array
    {
        $arrayUsers = [];
        $dir = null;
        try {
            // Считываем файлы и каталоги по указанному пути в DIR_BASE_USERS
            if ($dir = opendir(Paths::DIR_BASE_USERS)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == '.' || $file == '..' || $file == '.gitkeep') {
                        continue;
                    }
                    $arrayUsers[] = [$file => file(Paths::DIR_BASE_USERS . $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)];
                }
            }
        } catch (Exception $e) {
            var_dump($e);
        } finally {
            closedir($dir);
        }
        return $arrayUsers;
    }
}