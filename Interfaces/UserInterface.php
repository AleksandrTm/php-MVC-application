<?php

namespace Interfaces;

use Entities\User;

interface UserInterface
{
    public function getDataUsers(): array;

    public function checksUserRole(string $database, int $id, User $object = null): ?User;

    public function getDataForAuthorization(string $login): ?array;

    public function getDataUser(int $id): ?array;

    public function addUser(User $user): bool;

    public function editUser(User $user, int $id): void;

    public function writingDatabase(User $user, int $id = null, string $database = null, string $update = null): bool;
}