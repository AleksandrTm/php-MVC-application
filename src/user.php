<?php


class user
{
    protected string $name;
    protected string $pass;
    protected string $email;
    protected string $about;

    public function __construct($name, $pass, $email, $about)
    {
        $this->name = $name;
        $this->pass = $pass;
        $this->email = $email;
        $this->about = $about;
    }

}