<?php
session_start();

require 'db_connection.php';

/**
 * Script used by admins for promoting users
 *
 * Sets user role to admin
 */
$response = array("success" => false);
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $username = $_GET['username'];
    if ($_SESSION['role'] === 'admin') {
        $query = $conn->prepare("UPDATE users SET role = 'admin' WHERE username = ?");
        $query->bind_param("s", $username);
        $query->execute();
        $query->close();
        $response["success"] = true;
    } else
        $response["message"] = "You are not an admin";
}
die(json_encode($response));
