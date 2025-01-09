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
                $extensions = ['png', 'jpg', 'jpeg'];
                $path = "";
                foreach ($extensions as $ext) {
                    $tempPath = "media/users/".$_SESSION['login']."/profile_picture.".$ext;
                    if (file_exists($tempPath)) {
                        $path = $tempPath;
                        break;
                    }
                }
                if ($path)
                    echo '<img src="'.$path.'" alt="Avatar" class="write-pic">';
                else
                    echo '<img src="media/web/default_avatar.png" alt="Avatar" class="write-pic">';
                ?>
                <button class="write-submit">Post</button>
            </div>
            <form class="write-post">
                <div class="cloud">
                    <div class="spike"></div>
                    <textarea id="write-textarea" class="write-post-text"></textarea>
                </div>
            </form>
        </div>
    </main>
    <aside class="sidebar"></aside>
    <script src="scripts/home.js"></script>
</body>
</html>
