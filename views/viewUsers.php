<?php

use config\Paths;
use src\Model\Users;

?>
<!-- Начала Шаблона: header -->
<?php include_once '../views/template/header.html'; ?>
<!-- Конец Шаблона: header -->
<div class="container">
    <div class="table">
        <div class="table-head">
            <a href="/user/add" class="table-link">
                <img src="../img/add.png" alt="Add">
            </a>
        </div>
        <?php foreach (Users::viewsUsers() as $user): ?>
            <div class="table-row">
                <p><?php echo $user[3]; ?></p>
                <div class="add-delete">
                    <a href="/user/id/edit" class="table-link">
                        <img src="../img/edit.png" alt="Edit">
                    </a>
                    <a href="/user/id/delete" class="table-link">
                        <img src="../img/delete.png" alt="Delete">
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Начала Шаблона: footer -->
<?php include_once Paths::DIR_VIEWS . 'template/footer.html'; ?>
<!-- Конец Шаблона: footer -->