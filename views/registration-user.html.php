<?php

use config\Paths;
use Controllers\RegistrationController;

?>
<!-- Начала Шаблона: header -->
<?php include_once Paths::DIR_VIEWS . 'template/header.html'; ?>
<!-- Конец Шаблона: header -->
<div class="container">
    <div class="table">
        <?=
        $_SERVER['REQUEST_METHOD'] == "POST" ? RegistrationController::$info : null;
        ?>
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

                <div class="form-line">
                    <label for="date">Дата рождения</label>
                    <input id="date" type="date" name="date" value=""/>
                </div>

                <div class="form-line" id="text-area">
                    <label for="about">Описание</label>
                    <textarea name="about" id="about" cols="30" rows="10"></textarea>
                </div>

                <button id="submit" type="submit">Регистрация</button>

            </form>
        </div>
    </div>
</div>
<!-- Начала Шаблона: footer -->
<?php include_once Paths::DIR_VIEWS . 'template/footer.html'; ?>
<!-- Конец Шаблона: footer -->
