<?php
//Module การค้นหาและแสดงสินค้า

$Cid = isset($_GET['cid']) ? $_GET['cid'] : "";
$Invid = isset($_GET['inv_id']) ? $_GET['inv_id'] : "";


$invoice = "SELECT A.Inv_no, A.Inv_date, CONCAT(B.Cust_prename,B.Cust_firstname,' ',B.Cust_lastname) AS Customer_name, COUNT(C.Product_num) AS Qty, SUM(C.Product_num*C.Product_price) AS Amount, Inv_shipping, Cust_address, Cust_tel  
FROM invoice A INNER JOIN customer B ON (A.Inv_cust=B.Cust_id) INNER JOIN invoice_detail C ON (A.Inv_no = C.Inv_no) ";
if (!empty($Cid)) {
    $invoice .= " AND (Cust_id = '$Cid')";
}

if (!empty($Invid)) {
    $invoice .= " AND (A.Inv_no = '$Invid')";
}

$invoice .= " GROUP BY A.Inv_no, A.Inv_date, B.Cust_Prename, B.Cust_firstname, B.Cust_lastname, Inv_shipping , Cust_address, Cust_tel ";

$resultInvoice =  mysqli_query($conn, $invoice);
