<?php

use config\Paths;

$validation = require_once Paths::DIR_SRC . "Model/Validation.php";
?>
<!-- Начала Шаблона: header -->
<?php include_once Paths::DIR_VIEWS . 'template/header.html'; ?>
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
<?php include_once Paths::DIR_VIEWS . 'template/footer.html'; ?>
<!-- Конец Шаблона: footer -->