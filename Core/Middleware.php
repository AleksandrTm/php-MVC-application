<?php

namespace Core;

/**
 * Middleware обеспечивает возможность ограничить доступ для групп пользоваталей
 */
class Middleware
{
    protected ?string $userRole = null;

    public function __construct()
    {
        if(isset($_SESSION['role'])) {
            $this->userRole = $_SESSION['role'];
        }
    }

    /**
     * Разрешает доступ переданным группам
     *
     * Без аргументов: Разрешено всем
     *
     * Группы заносятся массивом ['user', 'admin']
     */
    function definesAccessRights(array $role = null): void
    {
        /**
         * Разрешает доступ переданным группам, остальным доступ запрещён
         *
         * Если пользователь входит в переданную группу, доступ разрещён, иначе запрещён
         */
        if (!in_array($this->userRole, $role)) {
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