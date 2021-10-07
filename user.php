<?php
$footer = require_once "./template/footer.php";
$header = require_once "./template/header.php";
$dataUser = require_once "./src/viewUser.php";
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>title</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="wrapper">
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
</div>
</body>
</html>