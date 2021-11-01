<div class="table">
        <?php foreach ($info as $result) { ?>
            <div><?php echo $result; ?></div>
        <?php } ?>
    <div class="forms">
        <h3>Регистрация</h3>
        <form id="send" method="post" action="">

            <input type="hidden" name="type-form" value="registration">

            <div class="form-line">
                <label for="login">Login: </label>
                <input id="login" type="text" name="login" value="" required/>
            </div>

            <div class="form-line">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" value="" required/>
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
                <input id="fullName" type="text" name="fullName" value=""/>
            </div>

            <div class="form-line">
                <label for="date">Дата рождения</label>
                <input id="date" type="date" name="date" value=""/>
            </div>

            <div class="form-line" id="text-area">
                <label for="about">Описание</label>
                <textarea name="about" id="about" cols="30" rows="10"></textarea>
            </div>

            <button id="submit" type="submit">Регистрация</button>

        </form>
    </div>
</div>
