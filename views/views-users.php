<div class="table">
    <div class="table-head">
        <?php if (($_SESSION['role'] ?? null) === "admin") { ?>
            <a href="/user/add" class="table-link">
                <img src="/../img/add.png" alt="Add">
            </a>
        <?php } ?>
    </div>
    <?php if (!array_key_exists('statusRemove', $info)) { ?>
        <?php foreach ($info ?? null as $userId => $userData): ?>
            <div class="table-row">
                <p><?= $userData['fullName'] ?></p>
                <?php if (($_SESSION['role'] ?? null) === "admin") { ?>
                    <div class="add-delete">
                        <a href="/user/<?= $userId ?>/edit" class="table-link">
                            <img src="/../img/edit.png" alt="Edit">
                        </a>
                        <a href="/user/<?= $userId ?>/delete" class="table-link">
                            <img src="/../img/delete.png" alt="Delete">
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php endforeach; ?>
    <?php } else { ?>
        <p><?= $info['statusRemove'] ?></p>
    <?php } ?>
    <?php if (isset($_GET['page'])) { ?>
        <div class="page-numbers">
            <?php if ($_GET['page'] > 1) { ?>
                <a href="/view/users?page=1" class="page-number"> << </a>
                <a href="/view/users?page=<?= $_GET['page'] - 1 ?>" class="page-number"><?= $_GET['page'] - 1 ?></a>
            <?php } ?>
            <div class="page-number"><?= $_GET['page'] ?></div>
            <?php if ($_GET['page'] < $_GET['countPage']) { ?>
                <a href="/view/users?page=<?= $_GET['page'] + 1 ?>" class="page-number"><?= $_GET['page'] + 1 ?></a>
                <a href="/view/users?page=<?= $_GET['countPage'] ?>" class="page-number"> >> </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>