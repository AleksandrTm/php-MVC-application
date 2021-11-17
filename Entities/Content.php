<?php

namespace Entities;

/**
 * Сущность контента ( получает данные из $_POST ) и хранит
 */
class Content
{
    private string $title;
    private string $text;

    public function __construct()
    {
        foreach ($_POST as $key => $value) {
            $value = strip_tags($value);
            $value = htmlentities($value, ENT_QUOTES, "UTF-8");

            if (!property_exists($this, $key)) {
                header('Location: /error');
            }
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
}

