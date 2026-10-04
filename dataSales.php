<?php
//Module การค้นหาและแสดงสินค้า

$month = isset($_GET['month']) ? $_GET['month'] : "";
$year = isset($_GET['year']) ? $_GET['year'] : "";


$invoice = "SELECT A.Inv_no, A.Inv_date, CONCAT(B.Cust_prename,B.Cust_firstname,' ',B.Cust_lastname) AS Customer_name, COUNT(C.Product_num) AS Qty, SUM(C.Product_num*C.Product_price) AS Amount, Inv_shipping, Cust_address, Cust_tel  
FROM invoice A INNER JOIN customer B ON (A.Inv_cust=B.Cust_id) INNER JOIN invoice_detail C ON (A.Inv_no = C.Inv_no) ";
if (!empty($month)) {
    $invoice .= " AND (substring(Inv_date,4,2) = '$month')";
}

if (!empty($year)) {
    $invoice .= " AND (right(Inv_date,4) = '$year')";
}

$invoice .= " GROUP BY A.Inv_no, A.Inv_date, B.Cust_Prename, B.Cust_firstname, B.Cust_lastname, Inv_shipping , Cust_address, Cust_tel ";

$resultInvoice =  mysqli_query($conn, $invoice);
