<?php

namespace Core;

use config\Paths;

/**
 * Отдаём нужные шаблоны и передаём в них значения для отображения
 *
 * Передаём в главный шаблон: title, имя шаблона, дополнительную информацию для обработки в массиве
 */
class View
{
    /**
     * $template: Имя подключаемого шаблона
     *
     * $title: Загаловок страницы
     *
     * $info: Массив данных для обработки в шаблоне
     */
    public function render(string $template, string $title, array $info = []): void
    {
        /** Добавляем путь к шаблону */
        $template = Paths::DIR_VIEWS . $template;

        /** Открываем главный шаблон, в него передаём параметры */
        require_once Paths::DIR_VIEWS . 'main.php';
    }
}