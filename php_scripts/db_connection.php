<?php

$hostname = "localhost";
$username = "";
$password = "";
$dbname = "";

/**
 * Create a new MySQLi connection.
 *
 * @var string $hostname The hostname of the MySQL server.
 * @var string $username The username to connect to the MySQL server.
 * @var string $password The password to connect to the MySQL server.
 * @var string $dbname The name of the database to connect to.
 * @var mysqli $conn The MySQLi connection object.
 */
$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
