<?php

use config\Paths;

?>
<!-- Начала Шаблона: header -->
<?php include_once Paths::DIR_VIEWS . 'template/header.html'; ?>
<!-- Конец Шаблона: header -->
<div class="container">
    <div class="table">
        <?= $info ?? null; ?>
    </div>
</div>
<!-- Начала Шаблона: footer -->
<?php include_once Paths::DIR_VIEWS . 'template/footer.html'; ?>
<!-- Конец Шаблона: footer -->