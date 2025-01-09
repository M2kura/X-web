<?php

require "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT role, password FROM users WHERE username = ?");
    $query->bind_param("s", $login);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $query->bind_result($role, $hashedPassword);
        $query->fetch();

        if (password_verify($password, $hashedPassword)) {

            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $role;

            $query->close();
            $conn->close();

            header("Location: /~teterheo/home");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found.";
    }

    $query->close();
    $conn->close();
}
