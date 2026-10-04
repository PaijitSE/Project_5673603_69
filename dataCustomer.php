<?php
//Module การค้นหาและแสดงสินค้า

$search = isset($_GET['cid']) ? $_GET['cid'] : "";


$sql5 = "SELECT * FROM customer A INNER JOIN customer_type B ON (A.Cust_level = B.Lev_id) WHERE 1";

if (!empty($search)) {
    $sql5 .= " AND (Cust_id = '$search')";
}

$resultsql5 =  mysqli_query($conn, $sql5);
