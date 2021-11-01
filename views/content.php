<div class="news">
    <h4><?= $info['titleContent'] ?></h4>
    <div class="remove-content"><?= $info['resultDelete'] ?? null ?></div>
    <?php if (($_SESSION['role'] ?? null) === "admin") { ?>
        <div class="table-head">
            <a href="/<?= $info['typeContent'] ?>/add" class="table-link">
                <img src="/../img/add.png" alt="Add">
            </a>
        </div>
    <?php } ?>
    <?php foreach ($info['content'] as $content) { ?>
        <div class="news-block">
            <div><b><?= $content['title'] ?></b></div>
            <div><?= $content['text'] ?></div>
            <div>Автор: <?= $content['author'] ?></div>
            <div>Дата публикации: <?= $content['date'] ?></div>
            <a href="/<?= $info['typeContent'] ?>/<?= $content['id'] ?>/view">Подробнее</a>
            <?php if (($_SESSION['role'] ?? null) === "admin") { ?>
                <div class="add-delete">
                    <a href="/<?= $info['typeContent'] ?>/<?= $content['id'] ?>/edit" class="table-link">
                        <img src="/../img/edit.png" alt="Edit">
                    </a>
                    <a href="/<?= $info['typeContent'] ?>/<?= $content['id'] ?>/delete" class="table-link">
                        <img src="/../img/delete.png" alt="Delete">
                    </a>
                </div>
            <?php } ?>
        </div>
        <?php $page = $content['page'] ?? null ?>
        <?php $pageMax = $content['countPage'] ?? null ?>
    <?php } ?>
    <?php if ($page ?? null) { ?>
        <div class="page-numbers">
            <?php if ($page > 1) { ?>
                <a href="/<?= $info['typeContent'] ?>?page=1" class="page-number"> << </a>
                <a href="/<?= $info['typeContent'] ?>?page=<?= $page - 1 ?>" class="page-number"><?= $page - 1 ?></a>
            <?php } ?>
            <div class="page-number"><?= $page ?></div>
            <?php if ($page < $pageMax) { ?>
                <a href="/<?= $info['typeContent'] ?>?page=<?= $page + 1 ?>" class="page-number"><?= $page + 1 ?></a>
                <a href="/<?= $info['typeContent'] ?>?page=<?= $pageMax ?>" class="page-number"> >> </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>