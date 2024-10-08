<?php

namespace Core;


/**
 * Обрабатывает URI и разбивает на параметры
 *
 * Отдаёт именнованый массив с параметрами $path: path/param + id
 *
 * При отсутсвии id, отдаёт $path: path/param
 */
class Router
{
    /**
     * ПЕРЕИМЕНОВАТЬ ПЕРЕМЕННЫЕ
     * ДАТЬ БОЛЕЕ ПРАВИЛЬНЫЕ НАЗВАНИЯ ( ПО СМЫСЛУ )
     */
    protected string $requestMethod;
    protected string $requestURI;
    protected string $uri;
    protected array $path;

    public function __construct()
    {
        $this->requestMethod = htmlspecialchars($_SERVER['REQUEST_METHOD']);
        $this->requestURI = htmlspecialchars(explode('?', $_SERVER['REQUEST_URI'])[0]);
        (new Sessions())->checksSession();
    }

    /**
     * Разбивает URI по слешу
     *
     * в случае если второе значение содержит цифры, определяем как id ( пользователя, новости, статьи ... )
     *
     * id сохраняется как отдельный параметр и убирается из URI для дальнейшей работы с ним
     *
     * URI хранит текстовый формат параметров в $uri
     */
    public function router(): void
    {
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////// ПЕРЕПИСАТЬ: УЙТИ ОТ НОМЕРОВАННЫХ ИНДЕКСОВ ////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $parsPath = explode('/', $this->requestURI);
        preg_match("([0-9]+)", array_key_exists(2, $parsPath) ? $parsPath[2] : null, $id);

        /**
         * Проверка на количество параметров в URI
         *
         * else если отсутствует параметр id пользователя для удаление и редактирования
         */
        if (count($parsPath) == 3) {
            $this->path = ['url' => array_key_exists(1, $parsPath) ? $parsPath[1] : null,
                'param' => array_key_exists(2, $parsPath) ? $parsPath[2] : null,
                'id' => array_key_exists(0, $id) ? $id[0] : null
            ];
        } else {
            $this->path = ['url' => array_key_exists(1, $parsPath) ? $parsPath[1] : null,
                'param' => array_key_exists(3, $parsPath) ? $parsPath[3] : null,
                'id' => array_key_exists(0, $id) ? $id[0] : null
            ];
        }

        $this->uri = is_null($this->path['param']) ? $this->path['url'] : $this->path['url'] . "/" . $this->path['param'];
    }
}