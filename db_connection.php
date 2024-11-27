<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cabinet_plus";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
