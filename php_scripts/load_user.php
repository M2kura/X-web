<?php
session_start();

require 'db_connection.php';

/**
 * Script used for fetching data about user to 
 * show on profile page
 *
 * Depending if the logged in user is an admin and if
 * the profile page is his, script returns different set
 * of data to be dinamicly displayd on the gui
 */
$response = array("success" => false);
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = $conn->prepare("SELECT username, role, pp_path, created_at FROM users WHERE username = ?");
    $query->bind_param("s", $_GET['username']);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $query->bind_result($username, $role, $pp_path, $joinDate);
        $query->fetch();
        if ($username === $_SESSION['login'])
            $response["isMe"] = true;
        else {
            $response["isMe"] = false;
            $response["myRole"] = $_SESSION['role'];
            $followQuery = $conn->prepare("SELECT 1 FROM follows WHERE follower = ? AND following = ?");
            $followQuery->bind_param("ss", $_SESSION['login'], $username);
            $followQuery->execute();
            $followQuery->store_result();
            if ($followQuery->num_rows > 0)
                $response["following"] = true;
            else
                $response["following"] = false;
            $followQuery->close();
        }
        $response["success"] = true;
        $response["username"] = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $response["avatar"] = $pp_path;
        $response["userRole"] = $role;
        $response["joinDate"] = $joinDate;
    } else
        $response["message"] = "User not found";

    $query->close();
    $conn->close();
}
echo json_encode($response);
