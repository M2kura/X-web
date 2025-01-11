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
    <link rel="stylesheet" href="styles/print.css" media="print">
    <title>Twixter: Home Page</title>
</head>
<body>
    <?php require "components/header.php" ?>
    <main class="content" id="content">
        <div class="posts-type">
            <h1 class="post-type-btn" id="world">World</h1>
            <h1 class="post-type-btn" id="following">Following</h1>
        </div>
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
    <script src="scripts/home.js"></script>
</body>
</html>
