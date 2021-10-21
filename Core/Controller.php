<?php

namespace Core;

class Controller
{
    protected ?View $view = null;

    public function __construct()
    {
        $this->view = new View();
    }
}