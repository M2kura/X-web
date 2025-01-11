<?php
require 'db_connection.php';

session_start();

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT username FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($postUsername);
    $stmt->fetch();
    $stmt->close();

    if ($postUsername === $_SESSION['login'] || $_SESSION['role'] === 'admin') {
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Post deleted successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to delete post';
        }
        $stmt->close();
    } else {
        $response['username'] = $postUsername;
        $response['success'] = false;
        $response['message'] = 'Unauthorized action';
    }

    $conn->close();
    echo json_encode($response);
}