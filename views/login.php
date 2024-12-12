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
        <form id="login-form">
            <label for="login">Login: </label>
            <input name="login" id="login-login" type="text" class="form-input">
            <label for="password">Password: </label>
            <input name="password" id="login-password" type="password" class="form-input">
            <button type="submit" id="submit-login">Log In</button>
            <a href="" class="redirect">Don't have an account?</a>
        </form>
    </div>
    <div id="form-signup" class="hidden">
        <h1>Sign Up Here</h1>
        <form id="signup-form">
            <label for="login">*Login: </label>
            <input name="login" id="signup-login" type="text" class="form-input">
            <label for="password">*Password: </label>
            <input name="password" id="signup-password" type="password" class="form-input">
            <label for="password-again">*Confirm password: </label>
            <input name="password-again" id="signup-password2" type="password" class="form-input">
            <label for="profile-picture">Profile picture: </label>
            <input name="profile-picture" id="profile-picture" type="file">
            <button id="clear-file" class="hidden">Clear file</button>
            <button type="submit" id="submit-signup">Sign Up</button>
            <p class="note">Required fields are marked with *</p>
            <a href="" class="redirect">Already have an account?</a>
        </form>
    </div>
    <script src="./scripts/login.js"></script>
    <script src="./scripts/signup.js"></script>
</body>
</html>
