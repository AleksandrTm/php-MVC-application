<div class="news">
    <h4><?= $info['titleContent'] ?></h4>
    <?php if (($_SESSION['role'] ?? null) === "admin") { ?>
        <div class="table-head">
        <a href="/<?= $info['typeContent'] ?>/add" class="table-link">
            <img src="/../img/add.png" alt="Add">
        </a>
    </div>
    <?php } ?>
    <?php foreach ($info['content'] as $id => $content) { ?>
        <div class="news-block">
            <div><b><?= $content['title'] ?></b></div>
            <div><?= $content['text'] ?></div>
            <div>Автор: <?= $content['author'] ?></div>
            <div>Дата публикации: <?= $content['date'] ?></div>
            <a href="/<?= $info['typeContent'] ?>/<?= $id ?>/view">Подробнее</a>
            <?php if (($_SESSION['role'] ?? null) === "admin") { ?>
                <div class="add-delete">
                    <a href="/<?= $info['typeContent'] ?>/<?= $id ?>/edit" class="table-link">
                        <img src="/../img/edit.png" alt="Edit">
                    </a>
                    <a href="/<?= $info['typeContent'] ?>/<?= $id ?>/delete" class="table-link">
                        <img src="/../img/delete.png" alt="Delete">
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="page-numbers">
        <a href="#" class="page-number">№ Page</a>
    </div>
</div>