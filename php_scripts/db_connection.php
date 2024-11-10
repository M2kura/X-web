<?php

$hostname = "localhost";
$username = "username";
$password = "password";
$dbname = "dbname";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}