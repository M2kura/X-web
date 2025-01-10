<?php
require "php_scripts/check_session.php";
isSessionDown();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/profile_page.css">
    <title>Twixter: Profile Page</title>
</head>
<body>
    <?php require "components/header.php" ?>
    <main class="content">
        <h1>Profile Page</h1>
        <h2>Hello, <?php echo($_SESSION['login']) ?></h2>
        <?php
            echo '<img src="'.$_SESSION['pp'].'" alt="Avatar" class="write-pic">';
        ?>
    </main>
    <aside class="sidebar"></aside>
</body>
</html>
