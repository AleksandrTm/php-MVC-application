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
            if (property_exists($this, $key)) {
                $this->$key = htmlspecialchars($value);
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
