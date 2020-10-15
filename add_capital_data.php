<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

$list = '';
$qty = 0;
$price = 0;
$total = 0;
$expend_date = null;
$cashier_name = '';

$recid = 0;


if (isset($_POST['list'])) {
    $list = $_POST['list'];
}
if (isset($_POST['qty'])) {
    $qty = $_POST['qty'];
}
if (isset($_POST['price'])) {
    $price = $_POST['price'];
}
if (isset($_POST['cashier_name'])) {
    $cashier_name = $_POST['cashier_name'];
}
if (isset($_POST['total_amount'])) {
    $total = $_POST['total_amount'];
}
if (isset($_POST['expend_date'])) {
    $expend_date = $_POST['expend_date'];
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}

$xx_date = null;
$d = explode('/',$expend_date);
if(count($d) >0){
    $xx_date = $d[2].'/'.$d[1].'/'.$d[0];
}
$x_date = date('Y-m-d', strtotime($xx_date));
//echo $x_date;return;


if ($recid <= 0 && $list != '') {
    $t_date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO capital (trans_date,list,qty,price,total,cashier_name,created_by,expend_date)
           VALUES ('$t_date','$list','$qty','$price','$total','$cashier_name',1,'$x_date')";

    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:capital.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:capital.php');
    }

} else {
    $sql = "UPDATE capital SET list='$list',qty='$qty',price='$price',total='$total',cashier_name='$cashier_name',created_by=1";
    $sql .= " WHERE id='$recid'";

    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:capital.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:capital.php');
    }
}

?>
