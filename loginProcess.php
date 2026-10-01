<?php
session_start();
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username  = trim($_POST["username"]);
    $password  = trim($_POST["password"]);

    echo $username . "<br>" . $password . "<br>";

    $sql = "SELECT * FROM checkUsers2 WHERE Emp_UN = '$username' 
            AND Emp_PW = '$password'";

    echo $sql . "<br>";

    $resultsql =  mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultsql) == 1) {
        //กรณีพบ Account

        $row = mysqli_fetch_assoc($resultsql);
        $_SESSION["id"]       = $row["Emp_id"];
        $_SESSION["fullname"] = $row["Emp_prename"] . $row["Emp_firstname"] . ' ' . $row["Emp_lastname"];
        $_SESSION["role"]     = $row["Roles"];

        echo "id=" . $_SESSION["id"] . "<br>";
        echo "name=" . $_SESSION["fullname"] . "<br>";
        echo "role=" . $_SESSION["role"];

        if ($_SESSION["role"] === "1") {
            echo "<script>window.location = 'profile.php?cid=" . $row["Emp_id"] . "';</script>";
        } else {
            echo "<script> window.location = 'product.php';</script>";
        }
    } else {
        //กรณีไม่พบ Account
        echo "<script>alert('ข้อมูลไม่ถูกต้อง'); 
                     window.location = 'index.php';
              </script>";
    }
} else {
    header("location : index.php");
}
