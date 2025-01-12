<?php
require 'db_connection.php';

session_start();

/**
 * Script for deleting a post
 *
 * Whether used by admin or a regular user, authorize the caller and deletes
 * related post from the database
 */
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
        $response['success'] = false;
        $response['message'] = 'Unauthorized action';
    }

    $conn->close();
    echo json_encode($response);
}
