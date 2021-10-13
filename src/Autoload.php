<?php
spl_autoload_register(function (string $className) {
    try {
        $path = str_replace('\\', '/', "../" . $className . '.php');
        require_once $path;
    } catch (Exception $e) {
        var_dump($e);
    }
});