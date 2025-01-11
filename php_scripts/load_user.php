<?php
session_start();

require 'db_connection.php';

$response = array("success" => false);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = $conn->prepare("SELECT username, pp_path FROM users WHERE username = ?");
    $query->bind_param("s", $_GET['username']);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $query->bind_result($username, $pp_path);
        $query->fetch();
        if ($username === $_SESSION['login'])
            $response["isMe"] = true;
        else
            $response["isMe"] = false;
        $response["success"] = true;
        $response["username"] = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $response["avatar"] = $pp_path;
    } else
        $response["message"] = "User not found";

    $query->close();
    $conn->close();
}
echo json_encode($response);
