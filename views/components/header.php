<header class="header">
    <a href="/~teterheo/home" class="logo-div">
        <img src="./media/web/logo_white.svg" alt="Logo" class="logo-img">
    </a>
    <a href="/~teterheo/" class="header-link">Home Page</a>
    <a href="/~teterheo/profile?username=<?php echo $_SESSION['login']?>" class="header-link">Profile</a>
    <form action="./php_scripts/logout_script.php" method="POST" class="header-link">
        <button type="submit">Log out</button>
    </form>
</header>
<aside class="sidebar"></aside>
