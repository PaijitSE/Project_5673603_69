<?php
$host = "localhost";
$user = "xx";
$pass = "xx";
$db   = "SEStoreDB_Prototype";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
