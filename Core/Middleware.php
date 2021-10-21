<?php

namespace Core;

use config\Permissions;

/**
 * Middleware между Роутером и Роутерами
 *
 * Обеспечивает права доступа по URI
 */
class Middleware extends Router
{
    protected ?string $getUserRole = null;

    public function __construct()
    {
        parent::__construct();
        $this->getUserRole = $_SESSION['role'];
        $this->router();
    }

    /**
     * Проверяет переданные группы, и определяет разрешён доступ или нет
     *
     * @$allowed : по дефолту кому разрешено, при установке false, кому запрещено
     *
     * @$role : передача ролей
     *
     * Без аргументов: Разрешено всем
     *
     * Группы заносятся массивом ['user', 'admin']
     */
    function middleware(array $role = null, bool $allowed = true): void
    {
        /**
         * Разрешает доступ переданным группам, остальным доступ запрещён
         */
        if (!in_array($this->getUserRole, $role)) {
            $this->deniesAccess();
        }
        /**
         *  Запрещает переданным группам доступ ( требуется указать второй аргумент $allowed = false )
         */
        if (in_array($this->getUserRole, $role) and !$allowed) {
            $this->deniesAccess();
        }
    }

    /**
     * Запрещает доступ, отдаёт 403 ошибку
     */
    function deniesAccess(): void
    {
        header('HTTP/1.1 403 Forbidden');
        echo 'Нет прав доступа';
        exit();
    }
}