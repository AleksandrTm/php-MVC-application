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
            <?= $valid ?>
            <div class="forms">
                <div id="signup-inner">
                    <p><a href="/">Главная</a><span>-></span>Добавить пользователя</p>
                    <form id="send" method="post" action="">
                        <p>
                            <label for="login">Login: </label>
                            <input id="login" type="text" name="login" value=""/>
                        </p>
                        <p>
                            <label for="email">E-mail</label>
                            <input id="email" type="email" name="email" value=""/>
                        </p>
                        <p>
                            <label for="password">password</label>
                            <input id="password" type="password" name="password" value=""/>
                        </p>
                        <p>
                            <label for="password-с">password confirm</label>
                            <input id="password-с" type="password" name="password-с" value=""/>
                        </p>
                        <p>password-с
                            <label for="full-name">ФИО</label>
                            <input id="full-name" type="text" name="full-name" value=""/>
                        </p>
                        <p>
                            <label for="date">Дата рождения</label>
                            <input id="date" type="date" name="country" value=""/>
                        </p>
                        <p>
                            <label for="about">Описание</label>
                            <textarea name="about" id="about" cols="30" rows="10"></textarea>
                        </p>
                        <p>
                            <button id="submit" type="submit">Добавить</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <div class="footer">
            <p>footer rights &copy; Aleksandr</p>
        </div>
    </footer>
</div>

</body>
</html>