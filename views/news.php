<div class="news">
    <h4>Список новостей за последнии 24 часа</h4>
    <?php foreach ($info as $content) { ?>
        <div class="news-block">
            <div><b><?= $content['titleNews'] ?></b></div>
            <div><?= $content['textNews'] ?></div>
            <div>Автор: <?= $content['author'] ?></div>
            <div>Дата публикации: <?= $content['date'] ?></div>
            <a href="#">Подробнее</a>
        </div>
    <?php } ?>
    <div class="page-numbers">
        <a href="#" class="page-number">№ Page</a>
    </div>
</div>