<div class="table">
    <div class="table-head">
        <?php if (($_SESSION['role'] ?? null) === "admin") { ?>
            <a href="/user/add" class="table-link">
                <img src="/../img/add.png" alt="Add">
            </a>
        <?php } ?>
    </div>
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
</div>