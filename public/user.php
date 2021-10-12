<?php

include_once "../config/Config.php";

use Localsite\Configs\Config;

$footer = require_once Config::DIR_VIEWS . 'template/footer.php';
$header = require_once Config::DIR_VIEWS . 'template/header.php';
$validation = require_once Config::DIR_SRC . "Validation.php";
$dataUser = require_once Config::DIR_SRC . "viewUser.php";
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
        <?php foreach ($dataUser as $user): ?>
            <?php echo $user; ?>
        <?php endforeach; ?>
    </div>
</div>
<!-- Начала Шаблона: footer -->
<?= $footer ?>
<!-- Конец Шаблона: footer -->