<header id="header">
    <div class="logo-div">
            <a href="/~teterheo/home"><img src="./media/web/logo_white.svg" alt="Logo" class="logo-img"></a>
    </div>
    <div class="profile-link">
        <a href="/~teterheo/profile">Profile</a>
    </div>
    <div class="create-post">
        <a href="">Create Post</a>
    </div>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="admin-section">
            <a href="admin_dashboard.php">Admin Dashboard</a>
        </div>
    <?php endif; ?>
    <div>
        <form action="./php_scripts/logout_script.php" method="POST">
            <button type="submit">Log out</button>
        </form>
    </div>
</header>