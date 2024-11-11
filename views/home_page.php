<?php require "./php_scripts/check_session.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twixter: Home Page</title>
</head>
<body>
    <p>Home Page</p>
    <form action="./php_scripts/logout_script.php" method="POST">
        <button type="submit">Log out</button>
    </form>
</body>
</html>