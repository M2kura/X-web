<?php

require "db_connection.php";
require "upload_picture.php";

session_start();

/**
 * Script responsable for signup of a new user.
 *
 * Validates all the inputs from the user
 * and restricts the signup if validation fails.
 *
 * If validation passed, creates a user's folder on the server,
 * inserts data into database and sets a session variables
 */
$response = array("success" => false);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordAgain = $_POST['password-again'];
    $profilePicture = $_FILES['profile-picture'];
    $role = "user";

    if (empty($login) || empty($password) || empty($passwordAgain)) {
        $response['message'] = "empty";
        die(json_encode($response));
    } else if (!preg_match('/^[a-zA-Z0-9_-]+$/', $login)) {
        $response['message'] = "bad-login";
        die(json_encode($response));
    } else if ($password !== $passwordAgain) {
        $response['message'] = "no-match";
        die(json_encode($response));
    } else if (strpos($login, ' ') || strpos($password, ' ') || strpos($passwordAgain, ' ')) {
        $response['message'] = "space";
        die(json_encode($response));
    } else if (strlen($login) > 24) {
        $response['message'] = "long-login";
        die(json_encode($response));
    } else if (strlen($password) < 8 || strlen($password) > 24) {
        $response['message'] = "lenght-pass";
        die(json_encode($response));
    }

    $query = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $query->bind_param("s", $login);
    $query->execute();
    $query->store_result();
    if ($query->num_rows > 0) {
        $response['message'] = "taken";
        $query->close();
        die(json_encode($response));
    }
    $query->close();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (isset($profilePicture) && $profilePicture['error'] != UPLOAD_ERR_NO_FILE) {
        $checkPicture = checkPicture($profilePicture);
        if (!$checkPicture['success']) {
            if ($checkPicture['message'] == "The file cannot be more then 5MB")
                $response['message'] = "file-size";
            else if ($checkPicture['message'] == "Allowed formats are: png, jpg")
                $response['message'] = "file-ext";
            die(json_encode($response));
        }
    } else
        $profilePicture = null;

    $query = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $query->bind_param("sss", $login, $hashedPassword, $role);

    if ($query->execute()) {
        mkdir("../media/users/".$login, 0777, true);
        $filePath = "media/web/default_avatar.png";
        $stmn = $conn->prepare("UPDATE users SET pp_path = ? WHERE username = ?");
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
        $response['success'] = true;

        $query->close();
        $conn->close();
        die(json_encode($response));
    } else {
        $response['message'] = "fail";
    }

    $query->close();
    $conn->close();
    die(json_encode($response));
}
