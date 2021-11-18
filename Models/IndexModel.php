<?php

namespace Models;

use Core\Model;
use Core\Pagination;
use Throwable;

class IndexModel extends Model
{
    private ?array $list = null;

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

    public function getItems(
        $catalog = null,
        $subCatalog = null,
        $brand = null,
        $size = null,
        $color = null
    ): ?array {
        $catalog = htmlentities(strip_tags($catalog), ENT_QUOTES, "UTF-8") ?? 'NULL';
        $subCatalog = htmlentities(strip_tags($subCatalog), ENT_QUOTES, "UTF-8") ?? 'NULL';
        $brand = htmlentities(strip_tags($brand), ENT_QUOTES, "UTF-8") ?? 'NULL';
        $size = htmlentities(strip_tags($size), ENT_QUOTES, "UTF-8") ?? 'NULL';
        $color = htmlentities(strip_tags($color), ENT_QUOTES, "UTF-8") ?? 'NULL';
//        $searchName = htmlentities(strip_tags($searchName), ENT_QUOTES, "UTF-8") ?? 'NULL';
//        $searchVendorCode = htmlentities(strip_tags($searchVendorCode), ENT_QUOTES, "UTF-8") ?? 'NULL';

        try {
            $result = $this->mysqlConnect->query(
                "SELECT i.name as itemName, i.vendor_code,
                c.name as catalog, c.id as idCatalog,
                b.name as brand, b.id as idBrand,
                ss.name as size, ss.id as idSize,
                cc.name as color, cc.id as idColor,
                sc.name as subCatalog, sc.id as idSubCatalog,
                i.vendor_code as vendorCode " .
                "FROM items i LEFT JOIN brand b ON i.brand = b.id " .
                "LEFT JOIN `catalog` c ON i.`catalog` = c.id " .
                "LEFT JOIN sub_catalog sc ON i.sub_catalog = sc.id " .
                "LEFT JOIN color cc ON i.color = cc.id " .
                "LEFT JOIN size ss ON i.size = ss.id " .
                "WHERE ($brand IS NULL OR (i.brand = $brand)) " .
                "AND ($catalog IS NULL OR (i.catalog = $catalog)) " .
                "AND ($subCatalog IS NULL OR (i.sub_catalog = $subCatalog)) " .
                "AND ($color IS NULL OR (i.color = $color)) " .
                "AND ($size IS NULL OR (i.size = $size));"
                //  AND CONCAT(i.name) LIKE '%154%'
            );

            while ($row = $result->fetch_assoc()) {
                $this->list[] = [
                    'itemName' => $row['itemName'],
                    'catalog' => $row['catalog'],
                    'subCatalog' => $row['subCatalog'],
                    'vendorCode' => $row['vendorCode'],
                    'size' => $row['size'],
                    'color' => $row['color'],
                    'brand' => $row['brand']
                ];
            }

            return $this->list;
        } catch (Throwable $t) {
            print $t;
            return null;
        }
    }
}