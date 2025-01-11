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
    <link rel="stylesheet" href="styles/home_page.css">
    <link rel="stylesheet" href="styles/print.css" media="print">
    <title>Twixter: Profile Page</title>
</head>
<body>
    <?php require "components/header.php" ?>
    <main class="content">
        <div class="profile-info">
            <div class="user-info">
                <img src="#" alt="Avatar" class="avatar" id="avatar">
                <p class="username" id="username"></p>
                <p id="role" class="role"></button>
            </div>
            <div class="user-btns" id="user-btns">
                <button id="change-btn" class="change-btn">Change profile</button>
            </div>
        </div>
        <form class="change-form hidden" id="change-form">
            <button id="close-btn" class="close-btn">&#10006;</button>
            <p class="message hidden" id="message"></p>
            <label for="login">New username: </label>
            <input name="login" id="login" type="text" class="form-input">
            <label for="profile-picture">New profile picture: </label>
            <input name="profile-picture" id="profile-picture" type="file" class="form-input">
            <button id="clear-file" class="hidden">Clear file</button>
            <button type="submit" id="submit-btn">Save changes</button>
        </form>
        <div class="feed" id="feed"></div>
    </main>
    <script src="scripts/profile.js"></script>
</body>
</html>
