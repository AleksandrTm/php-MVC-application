<?php
//include_once('../src/File.php');
require_once "../src/viewUser.php";
$arr = [];
for ($i = 0; $i <= 10; $i++) {
    $arr[$i] = "
                <div class=\"table-row\">
                
            <p>User Full name id: $i</p>
            <div class=\"add-delete\">
                <a href=\"/edit-user.php\" class=\"table-link\">
                    <img src=\"../img/edit.png\" alt=\"Edit\">
                </a>
                <a href=\"#\" class=\"table-link\">
                    <img src=\"../img/delete.png\" alt=\"Delete\">
                </a>
            </div>
        </div>
        ";
}
return $arr;