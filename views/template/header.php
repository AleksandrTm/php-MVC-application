<header>
    <div class="header">
        <a href="/"><img src="" alt="Logo"></a>
        <div class="links">
            <?php if (!isset($_SESSION['login'])) { ?>
                <a href="/login">Login</a>
                <span>/</span>
                <a href="/registration">Registration</a>
            <?php } else { ?>
                <?= $_SESSION['login'] ?? "guest"; ?>
                <span>/</span>
                <a href="/exit"> Exit</a>
            <?php } ?>
        </div>
    </div>
    <div class="menu">
        <a href="/">Главная</a>
        <span>|</span>
        <a href="/">Новости</a>
        <span>|</span>
        <a href="/">Статьи</a>
        <?php if (($_SESSION['role'] ?? null) != "guest") { ?>
        <span>|</span>
        <a href="/view/users">Пользователи</a>
        <?php } ?>
    </div>
</header>