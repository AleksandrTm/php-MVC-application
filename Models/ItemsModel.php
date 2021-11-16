<?php

namespace Models;

use Core\Model;
use Throwable;

class ItemsModel extends Model
{
    public function getList(string $table): ?array
    {
        try {
            $result = $this->mysqlConnect->query("SELECT * FROM $table ORDER BY name;");
            while ($row = $result->fetch_assoc()) {
                $list[$row['id']] = $row['name'];
            }
            return $list ?? null;
        } catch (Throwable $t) {
            return null;
        }
    }

    public function getItems($catalog = null,
                             $subCatalog = null,
                             $brand = null,
                             $size = null,
                             $color = null): ?array
    {
        $catalog = $catalog ?? 'NULL';
        $subCatalog = $subCatalog ?? 'NULL';
        $brand = $brand ?? 'NULL';
        $size = $size ?? 'NULL';
        $color = $color ?? 'NULL';
        try {
            $result = $this->mysqlConnect->query(
                "SELECT i.name as itemName, i.vendor_code,
    c.name as catalog, c.id as idCatalog,
    b.name as brand, b.id as idBrand,
    ss.name as size, ss.id as idSize,
    sc.name as subCatalog, sc.id as idSubCatalog,
    i.vendor_code as vendorCode  FROM " .
                " items i LEFT JOIN brand b ON i.brand = b.id" . "
                        LEFT JOIN `catalog` c ON i.`catalog` = c.id" . "
                        LEFT JOIN sub_catalog sc ON i.sub_catalog = sc.id" . "
                        LEFT JOIN size ss ON i.size = ss.id" . "
                        	WHERE " . "
                        ($brand IS NULL OR (i.brand = $brand)) " .
                " AND ($catalog IS NULL OR (i.catalog = $catalog))" .
                " AND ($subCatalog IS NULL OR (i.sub_catalog = $subCatalog))" .
                " AND ($size IS NULL OR (i.size = $size));");

            while ($row = $result->fetch_assoc()) {
                $list[] = ['itemName' => $row['itemName'],
                    'catalog' => $row['catalog'],
                    'subCatalog' => $row['subCatalog'],
                    'vendorCode' => $row['vendorCode'],
                    'size' => $row['size'],
                    'brand' => $row['brand']];
            }

            return $list ?? null;
        } catch (Throwable $t) {
            return null;
        }
    }
}