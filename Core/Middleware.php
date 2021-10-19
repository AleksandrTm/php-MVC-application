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
    protected string $getUserRole;

    public function __construct()
    {
        parent::__construct();
        $this->getUserRole = $_SESSION['role'];
        $this->router();
    }

    /**
     * Определяем какие URI доступны определенным правам доступа
     */
    function middleware()
    {
        switch ($this->uri) {
            case '':
                // Разрещено всем =\
                break;
            case 'login':
            case 'registration':
                $this->getGuestPermission() ?: $this->deniesAccess();
                break;
            case 'user/delete':
            case 'user/add':
            case 'user/edit':
                $this->getAdminPermission() ?: $this->deniesAccess();
                break;
            case 'exit':
                $this->getSharingPermission() ?: $this->deniesAccess();
                break;
            default:
                $this->deniesAccess();

        }
    }

    /**
     * Запрещает доступ, отдаёт 403 ошибку
     */
    function deniesAccess()
    {
        header('HTTP/1.1 403 Forbidden');
        echo 'Нет прав доступа';
        exit();
    }

    /**
     * Разрещено Администратору и зарегистированным пользователям
     */
    function getSharingPermission(): bool
    {
        return $this->getUserRole === Permissions::ROLE_ADMIN or $this->getUserRole === Permissions::ROLE_MEMBER;
    }

    /**
     * Не используется, права только для зарегистрированного пользователя, админу запрещено
     */
    function getMemberPermission(): bool
    {
        return $this->getUserRole === Permissions::ROLE_MEMBER;
    }

    /**
     * Права для Администратора
     */
    function getAdminPermission(): bool
    {
        return $this->getUserRole === Permissions::ROLE_ADMIN;
    }

    /**
     *  Права для гостей
     */
    function getGuestPermission(): bool
    {
        return $this->getUserRole === Permissions::ROLE_GUEST;
    }
}