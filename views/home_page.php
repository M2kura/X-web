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
        <div class="posts-type"></div>
        <div class="write-post-div">
            <div class="write-pic-div">
                <?php
                    echo '<img src="'.$_SESSION['pp'].'" alt="Avatar" class="write-pic">';
                ?>
                <button class="write-submit" id="send-post">Post</button>
            </div>
            <div class="cloud">
                <div class="spike"></div>
                <textarea id="write-textarea" class="write-post-text"></textarea>
            </div>
        </div>
        <div id="feed" class="feed"></div>
    </main>
    <aside class="sidebar"></aside>
    <script src="scripts/home.js"></script>
</body>
</html>
