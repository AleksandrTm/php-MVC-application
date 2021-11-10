<div class="table">
    <?php
    if (array_key_exists('resultEdit', $info)) {
        print $info['resultEdit'];
    }

    if (array_key_exists('valid', $info) && !is_null($info['valid'])) { ?>
        <?php foreach ($info['valid'] as $result) { ?>
            <div><?= $result ?></div>
        <?php } ?>
    <?php } ?>
    <?php if (!array_key_exists('userNotFound', $info)) { ?>
    <div class="forms">
        <h3>Редактирование пользователя</h3>
        <form id="send" method="post" action="">

            <input type="hidden" name="type-form" value="registration">

            <div class="form-line">
                <label for="login">Login: </label>
                <input id="login" type="text" name="login" value="<?= $info['data']['login'] ?? null ?>" required/>
            </div>

            <div class="form-line">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" value="<?= $info['data']['email'] ?? null ?>" required/>
            </div>

            <div class="form-line">
                <label for="password">password</label>
                <input id="password" type="password" name="password" value="" required/>
            </div>

            <div class="form-line">
                <label for="passwordConfirm">password confirm</label>
                <input id="passwordConfirm" type="password" name="passwordConfirm" value="" required/>
            </div>

            <div class="form-line">
                <label for="fullName">ФИО</label>
                <input id="fullName" type="text" name="fullName" value="<?= $info['data']['full_name'] ?? null ?>"/>
            </div>

            <div class="form-line">
                <label for="date">Дата рождения</label>
                <input id="date" type="date" name="date" value="<?= $info['data']['date'] ?? null ?>"/>
            </div>

            <div class="form-line" id="text-area">
                <label for="about">Описание</label>
                <textarea name="about" id="about" cols="30" rows="10"><?= $info['data']['about'] ?? null ?></textarea>
            </div>

            <button id="submit" type="submit">Сохранить изменения</button>

        </form>
        <?php } ?>
    </div>
</div>