<?php
//Module การค้นหาและแสดงสินค้า

$search1 = isset($_GET['keyword']) ? $_GET['keyword'] : "";
$search2 = isset($_GET['category']) ? $_GET['category'] : "";

$sql1 = "SELECT * FROM product WHERE 1";    //รายการสินค้า

if (!empty($search1) && ($search1 !== '')) {
    $sql1 .= " AND (Product_id LIKE '%$search1%' OR Product_name LIKE '%$search1%')";
}

if (!empty($search2) && ($search2 !== '')) {
    $sql1 .= " AND (Product_type = '$search2')";
}

$resultsql1 =  mysqli_query($conn, $sql1);
