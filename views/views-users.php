<?php

use Controllers\ViewUsersController;

?>
<!-- Начала Шаблона: header -->
<?php include_once 'template/header.html'; ?>
<!-- Конец Шаблона: header -->
<div class="container">
    <div class="table">
        <?=
        $_SERVER['REQUEST_METHOD'] == "POST" ? ViewUsersController::$arrayUsers : null;
        ?>
        <div class="table-head">
            <a href="/user/add" class="table-link">
                <img src="<?php __DIR__ ?>/../img/add.png" alt="Add">
            </a>
        </div>
        <?php foreach (ViewUsersController::getArrayUsers() as $users): ?>
            <?php foreach ($users as $key => $user): ?>
                <div class="table-row">
                    <p><?= $user[3] ?></p>
                    <div class="add-delete">
                        <a href="/user/<?= $key ?>/edit" class="table-link">
                            <img src="<?php __DIR__ ?>/../img/edit.png" alt="Edit">
                        </a>
                        <a href="/user/<?= $key ?>/delete" class="table-link">
                            <img src="<?php __DIR__ ?>/../img/delete.png" alt="Delete">
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>
<!-- Начала Шаблона: footer -->
<?php include_once 'template/footer.html'; ?>
<!-- Конец Шаблона: footer -->