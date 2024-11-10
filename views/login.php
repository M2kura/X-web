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
        <form>
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
        <form action="signup_script.php" method="POST">
            <label for="login">Login: </label>
            <input name="login" id="name" type="text">
            <label for="password">Password: </label>
            <input name="password" id="password" type="password">
            <label for="password-again">Confirm password: </label>
            <input name="password-again" id="password-again" type="password">
            <button type="submit" id="submit-signup">Sign Up</button>
            <a href="" id="link-to-login">Already have an account?</a>
        </form>
    </div>
    <script src="./scripts/login.js"></script>
</body>
</html>