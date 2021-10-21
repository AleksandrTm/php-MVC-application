<div class="table">
    <?php if (($info['statusAuthorization'] ?? null) === true) { ?>
        <p>Авторизация успешна</p>
    <?php } else { ?>
        <?php if (($info['statusAuthorization'] ?? null) === false) { ?>
            <p>Неверный логин или пароль</p>
        <?php } ?>
        <div class="forms">
            <form id="send" method="post" action="">
                <input type="hidden" name="type-form" value="login">

                <div class="form-line">
                    <label for="login">Login: </label>
                    <input id="login" type="text" name="login" value="" required/>
                </div>

                <div class="form-line">
                    <label for="password">password</label>
                    <input id="password" type="password" name="password" value="" required/>
                </div>

                <button id="submit" type="submit">Войти</button>

            </form>
        </div>
    <?php } ?>
</div>