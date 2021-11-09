<div class="table">
    <?php if(!array_key_exists('NotFound', $info)) { ?>
    <div class="forms">
        <h3><?= $info['title'] ?? null; ?></h3>
        <div><?= $info['result'] ?? null; ?></div>
        <form id="send" method="post" action="">

            <div class="form-line">
                <label for="title">Заголовок</label>
                <input id="title" type="text" name="title" value="<?= $info['data']['title'] ?? null ?>" required/>
            </div>

            <div class="form-line" id="text-area">
                <label for="text">Текст</label>
                <textarea name="text" id="text" cols="30" rows="10" required><?= $info['data']['text'] ?? null ?></textarea>
            </div>

            <button id="submit" type="submit">Добавить</button>

        </form>
        <?php } else { ?>
            <?= $info['NotFound'] ?? null; ?>
        <?php } ?>
    </div>
</div>