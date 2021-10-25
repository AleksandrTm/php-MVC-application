<div class="articles">
    <h4>Список статей</h4>
    <?php foreach ($info as $content) { ?>
        <div class="article">
            <div><b><?= $content['titleArticles'] ?></b></div>
            <div><?= $content['textArticles'] ?></div>
            <div>Автор: <?= $content['author'] ?></div>
            <div>Дата публикации: <?= $content['date'] ?></div>
            <a href="#">Подробнее</a>
        </div>
    <?php } ?>
    <div class="page-numbers">
        <a href="#" class="page-number">№ Page</a>
    </div>
</div>