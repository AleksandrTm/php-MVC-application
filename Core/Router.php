<?php

namespace Core;

/**
 * Обрабатывает URI и разбивает на параметры
 * Отдаёт именнованый массив с параметрами $path: path/param + id
 * При отсутсвии id, отдаёт $path: path/param
 */
class Router
{
    protected string $method;
    protected string $path;
    protected string $uri;
    protected array $pathArray;

    public function __construct()
    {
        $this->method = htmlspecialchars($_SERVER['REQUEST_METHOD']);
        $this->path = htmlspecialchars($_SERVER['REQUEST_URI']);

        // Выдаем роль пользователю, если у него её нет
        if (!isset($_SESSION['role'])) $_SESSION['role'] = 'guest';

    }

    public function router(): void
    {
        $parsPath = explode('/', $this->path);
        preg_match("([0-9]+)", array_key_exists(2, $parsPath) ? $parsPath[2] : null, $id);

        /**
         * Проверка на отсутсвие параметра id в path
         */
        if (count($parsPath) == 3) {
            $this->pathArray = ['url' => array_key_exists(1, $parsPath) ? $parsPath[1] : null,
                'param' => array_key_exists(2, $parsPath) ? $parsPath[2] : null,
                'id' => array_key_exists(0, $id) ? $id[0] : null
            ];
        } else {
            $this->pathArray = ['url' => array_key_exists(1, $parsPath) ? $parsPath[1] : null,
                'param' => array_key_exists(3, $parsPath) ? $parsPath[3] : null,
                'id' => array_key_exists(0, $id) ? $id[0] : null
            ];
        }
        $this->uri = !is_null($this->pathArray['param']) ? $this->pathArray['url'] . "/" . $this->pathArray['param'] : $this->pathArray['url'];
    }
}