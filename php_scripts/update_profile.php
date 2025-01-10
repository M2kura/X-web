<?php

require "db_connection.php";
require "upload_picture.php";

session_start();

$response = array("success" => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = htmlspecialchars($_POST['login']);
    $profilePicture = $_FILES['profile-picture'];

    if (empty($login) && (!isset($profilePicture) || $profilePicture['error'] == UPLOAD_ERR_NO_FILE)) {
        $response["message"] = "No changes were made";
        echo json_encode($response);
        exit;
    }

    if (empty($login))
        $login = $_SESSION['login'];
    else {
        if (!rename("../media/users/".$_SESSION['login'], "../media/users/".$login)) {
            $response["message"] = "Cannot chage the name";
            echo json_encode($response);
            exit;
        }
    }
    $filePath = "media/users/".$login."/profile_picture".strrchr($_SESSION['pp'], '.');
    if (isset($profilePicture) && $profilePicture['error'] != UPLOAD_ERR_NO_FILE) {
        $checkPicture = checkPicture($profilePicture);
        if ($checkPicture['success']) {
            $uploadPicture = uploadPicture($profilePicture, "../media/users/".$login."/profile_picture.");
            if ($uploadPicture['success'])
                $filePath = $uploadPicture['filePath'];
            else {
                $response["message"] = "Failed to upload picture";
                echo json_encode($response);
                exit;
            }
        } else {
            $response["message"] = "Invalid picture";
            echo json_encode($response);
            exit;
        }
    }

    $stmn1 = $conn->prepare("UPDATE users SET pp_path = ?, username = ? WHERE username = ?");
    $stmn1->bind_param("sss", $filePath, $login, $_SESSION['login']);
    $stmn2 = $conn->prepare("UPDATE posts SET username = ? WHERE username = ?");
    $stmn2->bind_param("ss", $login, $_SESSION['login']);
    if ($stmn1->execute() && $stmn2->execute()) {
        $response["success"] = true;
        $response['username'] = $login;
        $response['avatar'] = $filePath;
        $_SESSION['login'] = $login;
        $_SESSION['pp'] = $filePath;
    } else
        $response["message"] = "Failed to update profile";
    $stmn1->close();
    $stmn2->close();
    $conn->close();
}

echo json_encode($response);
