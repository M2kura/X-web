<?php

require "php_scripts/check_session.php";
isSessionUp();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/login.css">
    <title id="title">Twixter: Log In</title>
</head>
<body>
    <div id="form-login">
        <h1>Log In Here</h1>
        <form action="./php_scripts/login_script.php" method="POST">
            <label for="login">Login: </label>
            <input name="login" id="name" type="text">
            <label for="password">Password: </label>
            <input name="password" id="password" type="password">
            <button type="submit" id="submit-login">Log In</button>
            <a href="" id="link-to-signup">Don't have an account?</a>
        </form>
    </div>
    <div id="form-signup" class="hidden">
        <h1>Sign Up Here</h1>
        <form action="./php_scripts/signup_script.php" method="POST" enctype="multipart/form-data">
            <label for="login">Login: </label>
            <input name="login" id="name" type="text" required>
            <label for="password">Password: </label>
            <input name="password" id="password" type="password" required>
            <label for="password-again">Confirm password: </label>
            <input name="password-again" id="password-again" type="password" required>
            <label for="profile-picture">Profile picture: </label>
            <input name="profile-picture" id="profile-picture" type="file">
            <button id="clear-file" class="hidden">Clear file</button>
            <button type="submit" id="submit-signup">Sign Up</button>
            <a href="" id="link-to-login">Already have an account?</a>
        </form>
    </div>
    <script src="./scripts/login.js"></script>
</body>
</html>