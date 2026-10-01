<?php
$host = "localhost";
$user = "std67101";
$pass = "pro67101";
$db   = "SEStoreDB_Prototype";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
