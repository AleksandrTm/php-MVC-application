<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <link rel="icon" href="/../img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/../css/style.css">
</head>
<body>
<div class="wrapper">
    <!-- Начала Шаблона: header -->
    <?php include_once 'template/header.php'; ?>
    <!-- Конец Шаблона: header -->
    <div class="container">
        <!-- Начала Шаблона: container -->
        <?php include_once $template . '.php'; ?>
        <!-- Конец Шаблона: container -->
    </div>
    <!-- Начала Шаблона: footer -->
    <?php include_once 'template/footer.php'; ?>
    <!-- Конец Шаблона: footer -->
</div>
</body>
</html>