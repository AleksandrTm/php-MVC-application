<?php

include_once "../config/ConfigPaths.php";
include_once "../src/File.php";

use Localsite\Configs\ConfigPaths;
use Localsite\src\File;

$footer = require_once ConfigPaths::DIR_VIEWS . 'template/footer.php';
$header = require_once ConfigPaths::DIR_VIEWS . 'template/header.php';
$validation = require_once ConfigPaths::DIR_SRC . "Validation.php";
?>
<!-- Начала Шаблона: header -->
<?= $header ?>
<!-- Конец Шаблона: header -->
<div class="container">
    <div class="table">
        <div class="table-head">
            <a href="add-user.php" class="table-link">
                <img src="img/add.png" alt="Add">
            </a>
        </div>
        <?php foreach (File::viewsUsers() as $user): ?>
            <div class="table-row">
                <p><?php echo $user[3]; ?></p>
                <div class="add-delete">
                    <a href="/user/id/edit" class="table-link">
                        <img src="../img/edit.png" alt="Edit">
                    </a>
                    <a href="/user/id/delete" class="table-link">
                        <img src="../img/delete.png" alt="Delete">
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Начала Шаблона: footer -->
<?= $footer ?>
<!-- Конец Шаблона: footer -->