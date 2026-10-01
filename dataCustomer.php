<?php
//Module การค้นหาและแสดงสินค้า

$search = isset($_GET['cid']) ? $_GET['cid'] : "";


$sql5 = "SELECT * FROM customer WHERE 1";

if (!empty($search)) {
    $sql5 .= " AND (Cust_id = '$search')";
}

$resultsql5 =  mysqli_query($conn, $sql5);
