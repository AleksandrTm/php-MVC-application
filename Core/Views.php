<?php

namespace Core;

use config\Paths;

/**
 * Отдаём нужные шаблоны и передаём в них значения для отображения
 */
class Views
{
    private string $templatesPath = Paths::DIR_VIEWS;

    public function render(string $template, array $vars = [])
    {
//        /**
//         * Разбивает массив на переменные
//         */
//        extract($vars);

        require_once $this->templatesPath . $template;
    }
}