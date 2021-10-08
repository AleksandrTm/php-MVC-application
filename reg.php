<?php
$footer = require_once "./template/footer.php";
$header = require_once "./template/header.php";
$valid = require_once "./src/validation.php";
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
</head>
<body>
<div class="wrapper">
    <!-- Начала Шаблона: header -->
    <?= $header ?>
    <!-- Конец Шаблона: header -->
    <div class="container">
        <div class="table">
            <?= $valid ?>
            <div class="forms">
                <h2>Регистрация</h2>
                <form id="send" method="post" action="">
                    <input type="hidden" name="type-form" value="registration">
                    <div class="form-line">
                        <label for="login">Login: </label>
                        <input id="login" type="text" name="login" value=""/>
                    </div>

                    <div class="form-line">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" value=""/>
                    </div>

                    <div class="form-line">
                        <label for="password">password</label>
                        <input id="password" type="password" name="password" value=""/>
                    </div>

                    <div class="form-line">
                        <label for="passwordConfirm">password confirm</label>
                        <input id="passwordConfirm" type="password" name="passwordConfirm" value=""/>
                    </div>

                    <button id="submit" type="submit">Регистрация</button>

                </form>
            </div>
        </div>
    </div>
    <!-- Начала Шаблона: footer -->
    <?= $footer ?>
    <!-- Конец Шаблона: footer -->
