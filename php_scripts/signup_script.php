<?php

require "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordAgain = $_POST['password-again'];
    
    if ($password !== $passwordAgain) {
        die("Passwords don't match.");
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $query->bind_param("ss", $login, $hashedPassword);

    if ($query->execute()) {
        echo "New user created successfully.";
    } else {
        echo "Error: " . $query->error;
    }

    $query->close();
    $conn->close();
}