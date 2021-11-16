<div class="items">
    <form id="send" method="post" action="">
        <div class="sort">
            <div>Каталог</div>
            <div>Подкаталог</div>
            <div>Бренд</div>
            <div>Размер</div>
            <div>Цвет</div>
            <select name="catalog" id="catalog">
                <?php if($_POST['catalog'] > 0) { ?>
                    <option value="<?= $_POST['catalog'] ?>"><?=$info['catalog'][$_POST['catalog']]?></option>
                <?php } ?>
                <option value="NULL">Все</option>
                <?php foreach ($info['catalog'] as $key => $value) { ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
            </select>
            <select name="subCatalog" id="sub-catalog">
                <?php if($_POST['subCatalog'] > 0) { ?>
                    <option value="<?= $_POST['subCatalog'] ?>"><?=$info['subCatalog'][$_POST['subCatalog']]?></option>
                <?php } ?>
                <option value="NULL">Все</option>
                <?php foreach ($info['subCatalog'] as $key => $value) { ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
            </select>
            <select name="brand" id="brand">
                <?php if($_POST['brand'] > 0) { ?>
                    <option value="<?= $_POST['brand'] ?>"><?=$info['brand'][$_POST['brand']]?></option>
                <?php } ?>
                <option value="NULL">Все</option>
                <?php foreach ($info['brand'] as $key => $value) { ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
            </select>
            <select name="size" id="size">
                <?php if($_POST['size'] > 0) { ?>
                    <option value="<?= $_POST['size'] ?>"><?=$info['size'][$_POST['size']]?></option>
                <?php } ?>
                <option value="NULL">Все</option>
                <?php foreach ($info['size'] as $key => $value) { ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
            </select>
            <select name="color" id="color">
                <?php if($_POST['color'] > 0) { ?>
                    <option value="<?= $_POST['color'] ?>"><?=$info['color'][$_POST['color']]?></option>
                <?php } ?>
                <option value="NULL">Все</option>
                <?php foreach ($info['color'] as $key => $value) { ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
            </select>
            <button class="search" type="submit">Найти</button>
        </div>
    </form>

    <div class="sort__table">
        <div class="sort__column">Название</div>
        <div class="sort__column">Артикул</div>
        <div class="sort__column">Раздел каталога</div>
        <div class="sort__column">Подразел каталога</div>
        <div class="sort__column">Бренд</div>
        <div class="sort__column">Модель</div>
        <div class="sort__column">Размер</div>
        <div class="sort__column">Цвет</div>
        <div class="sort__column">Ориентация для клюшек</div>
    </div>
    <?php if (!empty($info['items'])) {
        foreach ($info['items'] as $key => $item) { ?>
            <?php if($key === 'post') continue; ?>
            <div class="sort__items">
                <div class="sort__column"><?= $item['itemName'] ?></div>
                <div class="sort__column"><?= !empty($item['vendorCode']) ? $item['vendorCode'] : '-' ?></div>
                <div class="sort__column"><?= !empty($item['catalog']) ? $item['catalog'] : '-' ?></div>
                <div class="sort__column"><?= !empty($item['subCatalog']) ? $item['subCatalog'] : '-' ?></div>
                <div class="sort__column"><?= !empty($item['brand']) ? $item['brand'] : '-' ?></div>
                <div class="sort__column"><?= !empty($item['model']) ? $item['model'] : '-' ?></div>
                <div class="sort__column"><?= !empty($item['size']) ? $item['size'] : '-' ?></div>
                <div class="sort__column"><?= !empty($item['color']) ? $item['color'] : '-' ?></div>
                <div class="sort__column"><?= !empty($item['orin']) ? $item['orin'] : '-' ?></div>
            </div>
        <?php }
    } ?>
</div>