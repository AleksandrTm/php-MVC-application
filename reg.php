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
    <title>title</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="wrapper">
    <!-- Начала Шаблона: header -->
    <?= $header ?>
    <!-- Конец Шаблона: header -->
    <div class="container">
        <div class="table">
            <div class="forms">
                <div id="signup-inner">
                    <p>
                    <h1>Регистрация</h1></p>
                    <form id="send" action="reg.php" method="post">
                        <p>
                            <label for="login">Login: </label>
                            <input id="login" type="text" name="login" value=""/>
                        </p>
                        <p>
                            <label for="email">E-mail</label>
                            <input id="email" type="email" name="email" value=""/>
                        </p>
                        <p>
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" value=""/>
                        </p>
                        <p>
                            <label for="password">Password confirm</label>
                            <input id="password" type="password" name="password" value=""/>
                        </p>
                        <p>
                            <label for="full-name">ФИО</label>
                            <input id="full-name" type="text" name="full-name" value=""/>
                        </p>
                        <p>
                            <label for="country">Дата рождения</label>
                            <input id="Country" type="text" name="country" value=""/>
                        </p>
                        <p>
                            <button id="submit" type="submit">Регистрация</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Начала Шаблона: footer -->
    <?= $footer ?>
    <!-- Конец Шаблона: footer -->
</div>

</body>
</html>