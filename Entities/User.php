<?php

namespace Entities;

/**
 * Сущность пользователя ( получает данные из $_POST по дефолту ) и хранит их в сущности
 */
class User
{
    private int $id;
    private string $login;
    private string $password;
    private string $passwordConfirm;
    private string $email;
    private string $fullName;
    private string $date;
    private string $about;
    private string $role;

    public function __construct(array $data = null)
    {
        if (!isset($data)) {
            $data = $_POST;
        }
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = htmlspecialchars($value);
            }
        }
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordConfirm(): string
    {
        return $this->passwordConfirm;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getAbout(): string
    {
        return $this->about;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setPasswordConfirm(string $passwordConfirm): void
    {
        $this->passwordConfirm = $passwordConfirm;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function setAbout(string $about): void
    {
        $this->about = $about;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }
}