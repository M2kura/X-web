<?php

require "db_connection.php";

$response = array("success" => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (empty($login) || empty($password) || strlen($login) > 24 || strlen($password) < 8 ||
        strlen($password) > 24 || strpos($login, ' ') || strpos($password, ' ')) {
        $response['message'] = "problem";
        die(json_encode($response));
    }

    $query = $conn->prepare("SELECT role, pp_path, password FROM users WHERE username = ?");
    $query->bind_param("s", $login);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $query->bind_result($role, $pp_path, $hashedPassword);
        $query->fetch();
        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $role;
            $_SESSION['pp'] = $pp_path;
            $response['success'] = true;

            $query->close();
            $conn->close();
            die(json_encode($response));
        } else {
            $response['message'] = "problem";
        }
    } else {
        $response['message'] = "problem";
    }

    $query->close();
    $conn->close();
    die(json_encode($response));
}
