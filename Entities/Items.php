<?php

namespace Entities;

class Items
{
    private string $catalog;
    private string $subCatalog;
    private string $brand;
    private string $size;
    private string $color;

    public function __construct()
    {
        foreach ($_POST as $key => $value) {
            $value = strip_tags($value);
            $value = htmlentities($value, ENT_QUOTES, "UTF-8");
            $value = htmlspecialchars($value, ENT_QUOTES);
            if (!property_exists($this, $key)) {
                header('Location: /error');
            }
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getCatalog(): string
    {
        return $this->catalog;
    }

    public function setCatalog(string $catalog): void
    {
        $this->catalog = $catalog;
    }

    public function getSubCatalog(): string
    {
        return $this->subCatalog;
    }

    public function setSubCatalog(string $subCatalog): void
    {
        $this->subCatalog = $subCatalog;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }
}