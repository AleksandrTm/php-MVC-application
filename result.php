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
        <?php
        $name = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["login"];
        }

        var_dump($_SERVER);
        ?>
        <!-- Начала Шаблона: footer -->
        <?= $footer ?>
        <!-- Конец Шаблона: footer -->
    </div>

</body>
</html>
