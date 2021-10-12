<?php

include_once "../config/ConfigPaths.php";

use Localsite\Configs\ConfigPaths;

$footer = require_once ConfigPaths::DIR_VIEWS . 'template/footer.php';
$header = require_once ConfigPaths::DIR_VIEWS . 'template/header.php';
$validation = require_once ConfigPaths::DIR_SRC . "Validation.php";
?>
<!-- Начала Шаблона: header -->
<?= $header ?>
<!-- Конец Шаблона: header -->
<div class="container">
    <div class="table">
        <?= $validation ?>
        <div class="forms">
            <form id="send" method="post" action="">
                <input type="hidden" name="type-form" value="login">

                <div class="form-line">
                    <label for="login">Login: </label>
                    <input id="login" type="text" name="login" value="" required/>
                </div>

                <div class="form-line">
                    <label for="password">password</label>
                    <input id="password" type="password" name="password" value="" required/>
                </div>

                <button id="submit" type="submit">Добавить</button>

            </form>
        </div>
    </div>
</div>
<!-- Начала Шаблона: footer -->
<?= $footer ?>
<!-- Конец Шаблона: footer -->