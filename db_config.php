<?php
$host = "localhost";
$user = "root";
$password = "Bareera@21";
$database = "contact_management";
global $conn;

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->close();
?>
