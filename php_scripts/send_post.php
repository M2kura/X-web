<?php
require 'db_connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postContent = trim($_POST['postText']);

    if (empty($postContent)) {
        echo 'Post content cannot be empty.';
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO posts (username, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $_SESSION['login'], $postContent);

    if ($stmt->execute()) {
        echo 'Post submitted successfully.';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
