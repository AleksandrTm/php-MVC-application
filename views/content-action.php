<div class="table">
    <?php foreach ($info ?? null as $result) { ?>
        <div><?php echo $result; ?></div>
    <?php } ?>
    <?php if(!array_key_exists('NotFound', $info)) { ?>
    <div class="forms">
        <h3><?= $info['title'] ?? null; ?></h3>
        <form id="send" method="post" action="">

            <input type="hidden" name="type-form" value="<?= $info['type'] ?? null; ?>">

            <div class="form-line">
                <label for="title">Заголовок</label>
                <input id="title" type="text" name="title" value="" required/>
            </div>

            <div class="form-line" id="text-area">
                <label for="text">Текст</label>
                <textarea name="text" id="text" cols="30" rows="10" required></textarea>
            </div>

            <button id="submit" type="submit">Добавить</button>

        </form>
        <?php } else { ?>
            <?= $info['NotFound'] ?? null; ?>
        <?php } ?>
    </div>
</div>