<?php
require 'db_connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $case = $_GET['case'];

    if ($case === "users") {
        $stmt = $conn->prepare("
            SELECT posts.content, posts.created_at, users.pp_path
            FROM posts
            JOIN users ON posts.username = users.username
            WHERE posts.username = ?
            ORDER BY posts.id DESC
        ");
        $stmt->bind_param("s", $_SESSION['login']);
    } else if ($case === "all") {
        $stmt = $conn->prepare("
            SELECT posts.username, posts.content, posts.created_at, users.pp_path
            FROM posts
            JOIN users ON posts.username = users.username
            ORDER BY posts.id DESC
        ");
    }
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $posts = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($posts as &$post) {
            $post['username'] = htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8');
            $post['content'] = htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8');
        }
        echo json_encode($posts);
    } else {
        echo json_encode(['error' => 'Error: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
}
