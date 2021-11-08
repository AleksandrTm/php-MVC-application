<?php

namespace Core;

/**
 * Базовый Контроллер
 *
 * Создаёт обязательный для всех контроллеров View объект
 */
class Controller
{
    protected ?View $view = null;
    public array $appConfig;

    public function __construct()
    {
        $this->view = new View();
        $this->appConfig = include "../config/app.php";
    }
}