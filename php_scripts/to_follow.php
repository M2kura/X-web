<?php
session_start();

require 'db_connection.php';

$response = array("success" => false);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $method = $_GET['method'];
    $username = $_GET['username'];

    if ($method === "follow") {
        $stmt = $conn->prepare("INSERT INTO follows (follower, following) VALUES (?, ?)");
        $stmt->bind_param("ss", $_SESSION['login'], $username);
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Successfully followed $username";
        } else {
            $response["message"] = "Failed to follow $username";
        }
        $stmt->close();
    } else if ($method === "unfollow") {
        $stmt = $conn->prepare("DELETE FROM follows WHERE follower = ? AND following = ?");
        $stmt->bind_param("ss", $_SESSION['login'], $username);
        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Successfully unfollowed $username";
        } else {
            $response["message"] = "Failed to unfollow $username";
        }
        $stmt->close();
    } else {
        $response["message"] = "Invalid method";
    }
}

$conn->close();
echo json_encode($response);