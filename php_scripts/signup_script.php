<?php

require "db_connection.php";
require "upload_picture.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = htmlspecialchars($_POST['login']);
    $password = $_POST['password'];
    $passwordAgain = $_POST['password-again'];
    $profilePicture = $_FILES['profile-picture'];
    $role = "user";

    if ($password !== $passwordAgain) {
        die("Passwords don't match.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (isset($profilePicture) && $profilePicture['error'] != UPLOAD_ERR_NO_FILE) {
        $checkPicture = checkPicture($profilePicture);
        if (!$checkPicture['success'])
            die($checkPicture['message']);
    } else
        $profilePicture = null;

    $query = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $query->bind_param("sss", $login, $hashedPassword, $role);

    if ($query->execute()) {
        mkdir("../media/users/".$login, 0777, true);
        $stmn = $conn->prepare("UPDATE users SET pp_path = ? WHERE username = ?");
        $filePath = "media/web/default_avatar.png";

        if ($profilePicture != null) {
            $uploadPicture = uploadPicture($profilePicture, "../media/users/".$login."/profile_picture.");
            if ($uploadPicture['success'])
                $filePath = $uploadPicture['filePath'];
        }
        $stmn->bind_param("ss", $filePath, $login);
        $stmn->execute();
        $stmn->close();

        $_SESSION['login'] = $login;
        $_SESSION['role'] = $role;
        $_SESSION['pp'] = $filePath;

        $query->close();
        $conn->close();

        header("Location: /~teterheo/home");
        exit();
    } else
        echo "Error: " . $query->error;

    $query->close();
    $conn->close();
}
