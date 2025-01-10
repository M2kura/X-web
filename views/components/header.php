<header class="header">
    <a href="/~teterheo/home" class="logo-div">
        <img src="./media/web/logo_white.svg" alt="Logo" class="logo-img">
    </a>
    <a href="/~teterheo/" class="header-link">Home Page</a>
    <a href="/~teterheo/profile" class="header-link">Profile</a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="admin_dashboard.php">Admin Dashboard</a>
    <?php endif; ?>
    <form action="./php_scripts/logout_script.php" method="POST" class="header-link">
        <button type="submit">Log out</button>
    </form>
</header>
<aside class="sidebar"></aside>
