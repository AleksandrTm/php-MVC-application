<?php

namespace Core;


class Middleware
{
    protected ?string $userRole = null;

    public function __construct()
    {
        $this->userRole = $_SESSION['role'];
    }

    /**
     * True если пользователь админ или обычный зарегистрированный пользователь
     */
    function checkGeneralRols(): bool
    {
        return $this->userRole === Permissions::ROLE_ADMIN or $this->userRole === Permissions::ROLE_MEMBER;
    }

    function checkMemberRols(): bool
    {
        return $this->userRole === Permissions::ROLE_MEMBER;
    }

    function checkAdminRols(): bool
    {
        return $this->userRole === Permissions::ROLE_ADMIN;
    }

    function checkGuestRols(): bool
    {
        return $this->userRole === Permissions::ROLE_ADMIN;
    }
}