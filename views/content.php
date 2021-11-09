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
    <?php if (!array_key_exists('error', $info['content'])) { ?>
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
        <?php } ?>
    <?php } else {
        print 'ошибка подключения к таблице,<br> возможно таблица отсутствует';
    } ?>
    <?php if (isset($_GET['countPage'])) { ?>
        <div class="page-numbers">
            <?php if ($_GET['page'] > 1) { ?>
                <a href="/<?= $info['typeContent'] ?>?page=1" class="page-number"> << </a>
                <a href="/<?= $info['typeContent'] ?>?page=<?= $_GET['page'] - 1 ?>"
                   class="page-number"><?= $_GET['page'] - 1 ?></a>
            <?php } ?>
            <div class="page-number"><?= $_GET['page'] ?></div>
            <?php if ($_GET['page'] < $_GET['countPage']) { ?>
                <a href="/<?= $info['typeContent'] ?>?page=<?= $_GET['page'] + 1 ?>"
                   class="page-number"><?= $_GET['page'] + 1 ?></a>
                <a href="/<?= $info['typeContent'] ?>?page=<?= $_GET['countPage'] ?>" class="page-number"> >> </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>