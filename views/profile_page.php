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
        <div class="profile-info">
            <img src="<?php echo $_SESSION['pp']?>" alt="Avatar" class="avatar" id="avatar">
            <p class="username" id="username"><?php echo $_SESSION['login']?></p>
            <button id="change-btn" class="change-btn">Change profile</button>
        </div>
        <form class="change-form hidden" id="change-form">
            <button id="close-btn" class="close-btn">&#10006</button>
            <p class="message hidden" id="message"></p>
            <label for="login">New username: </label>
            <input name="login" id="login" type="text" class="form-input">
            <label for="profile-picture">New profile picture: </label>
            <input name="profile-picture" id="profile-picture" type="file" class="form-input">
            <button id="clear-file" class="hidden">Clear file</button>
            <button type="submit" id="submit-btn">Save changes</button>
        </form>
    </main>
    <script src="scripts/profile.js"></script>
</body>
</html>
