<?php


class user
{
    protected int $id;
    protected string $name;
    protected string $pass;
    protected string $email;
    protected string $about;

    public function __construct($id, $name, $pass, $email, $about)
    {
        $this->id = $id;
        $this->name = $name;
        $this->pass = $pass;
        $this->email = $email;
        $this->about = $about;
    }

}