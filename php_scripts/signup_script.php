<?php

require "db_connection.php";
require "upload_picture.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $login = $_POST['login'];
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
        if (!$checkPicture['success']) {
            die($checkPicture['message']);
        }
    } else {
        $profilePicture = null;
    }

    $query = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $query->bind_param("sss", $login, $hashedPassword, $role);

    if ($query->execute()) {
        mkdir("../media/users/".$login, 0777, true);
        if ($profilePicture != null) {
            $uploadPicture = uploadPicture($profilePicture, "../media/users/".$login."/profile_picture.");
            if (!$uploadPicture['success']) {
                die($uploadPicture['message']);
           }
        }

        $_SESSION['login'] = $login;

        $query->close();
        $conn->close();

        header("Location: /~teterheo/home");
        exit();
    } else {
        echo "Error: " . $query->error;
    }

    $query->close();
    $conn->close();
}
