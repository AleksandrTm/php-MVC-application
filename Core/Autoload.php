<?php
/**
 * Автолоадер: автоматически загружает классы с помощью require_once
 *
 * Возможность использовать импорты ( use ) без подключения файлов
 */
spl_autoload_register(function (string $className) {
    try {
        $path = str_replace('\\', '/', "../" . $className . '.php');
        require_once $path;
    } catch (Exception $e) {
        var_dump($e);
    }
});