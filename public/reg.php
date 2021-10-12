<?php

include_once "../config/Config.php";

use Localsite\Configs\Config;

$footer = require_once Config::DIR_VIEWS . 'template/footer.php';
$header = require_once Config::DIR_VIEWS . 'template/header.php';
$validation = require_once Config::DIR_SRC . "validation.php";
?>

<!-- Начала Шаблона: header -->
<?= $header ?>
<!-- Конец Шаблона: header -->
<div class="container">
    <div class="table">
        <?= $validation ?>
        <div class="forms">
            <h2>Регистрация</h2>
            <form id="send" method="post" action="">
                <input type="hidden" name="type-form" value="registration">
                <div class="form-line">
                    <label for="login">Login: </label>
                    <input id="login" type="text" name="login" value="" required/>
                </div>

                <div class="form-line">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" name="email" value="" required/>
                </div>

                <div class="form-line">
                    <label for="password">password</label>
                    <input id="password" type="password" name="password" value="" required/>
                </div>

                <div class="form-line">
                    <label for="passwordConfirm">password confirm</label>
                    <input id="passwordConfirm" type="password" name="passwordConfirm" value="" required/>
                </div>

                <div class="form-line">
                    <label for="fullName">ФИО</label>
                    <input id="fullName" type="text" name="fullName" value=""/>
                </div>

                <button id="submit" type="submit">Регистрация</button>

            </form>
        </div>
    </div>
</div>
<!-- Начала Шаблона: footer -->
<?= $footer ?>
<!-- Конец Шаблона: footer -->
