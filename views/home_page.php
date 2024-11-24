<?php 
require "./php_scripts/check_session.php";
isSessionDown();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/home_page.css">
    <title>Twixter: Home Page</title>
</head>
<body>
    <?php require "components/header.php" ?>
    <main class="content">
        <h1>Home Page</h1>
    </main>
    <aside class="sidebar"></aside>
</body>
</html>