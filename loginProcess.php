<?php
session_start();
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username  = trim($_POST["username"]);
    $password  = trim($_POST["password"]);

    $sql = "SELECT * FROM checkUsers2 WHERE Emp_UN = '$username' 
            AND Emp_PW = '$password'";

    $resultsql =  mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultsql) == 1) {
        //กรณีพบ Account

        $row = mysqli_fetch_assoc($resultsql);
        $_SESSION["id"]       = $row["Emp_id"];
        $_SESSION["fullname"] = $row["Emp_prename"] . $row["Emp_firstname"] . ' ' . $row["Emp_lastname"];
        $_SESSION["role"]     = $row["Roles"];

        echo json_encode(["status" => "success", "message" => $row["Roles"], "id" => $row["Emp_id"]]);
        exit();
    } else {
        //กรณีไม่พบ Account
        echo json_encode(["status" => "error", "message" => "ไม่พบสิทธิ์เข้าใช้งาน !"]);
        exit();
    }
} else {
    echo json_encode(["status" => "error", "message" => "E-ไม่อนุญาตให้เข้าถึงระบบ"]);
    exit();
}
