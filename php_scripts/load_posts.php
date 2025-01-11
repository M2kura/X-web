<?php
require 'db_connection.php';

session_start();

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $case = $_GET['case'];
    $username = isset($_GET['username']) ? $_GET['username'] : null;
    $count = isset($_GET['count']) ? $_GET['count'] : 0;
    $limit = 10;

    if ($case === "users") {
        $stmt = $conn->prepare("
            SELECT posts.id, posts.username, posts.content, posts.created_at, users.pp_path
            FROM posts
            JOIN users ON posts.username = users.username
            WHERE posts.username = ?
            ORDER BY posts.id DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->bind_param("sii", $username, $limit, $count);
    } else if ($case === "following") {
        $stmt = $conn->prepare("
            SELECT posts.id, posts.username, posts.content, posts.created_at, users.pp_path
            FROM posts
            JOIN users ON posts.username = users.username
            JOIN follows ON posts.username = follows.following
            WHERE follows.follower = ?
            ORDER BY posts.id DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->bind_param("sii", $_SESSION['login'], $limit, $count);
    } else if ($case === "all") {
        $stmt = $conn->prepare("
            SELECT posts.id, posts.username, posts.content, posts.created_at, users.pp_path
            FROM posts
            JOIN users ON posts.username = users.username
            ORDER BY posts.id DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->bind_param("ii", $limit, $count);
    }
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $posts = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($posts as &$post) {
            $post['username'] = htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8');
            $post['content'] = htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8');
        }
        $response['posts'] = $posts;
        $response['role'] = $_SESSION['role'];
        $response['login'] = $_SESSION['login'];
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Error: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
}
