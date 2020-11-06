<?php
ob_start();
session_start();
include("common/dbcon.php");
include("models/BankTransModel.php");

$account_name = '';
$bank_account = '';
$bank_id = 0;
$adjust_amount = 0;
$user_id = 0;

$recid = 0;

if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
}

if (isset($_POST['account_name'])) {
    $account_name = $_POST['account_name'];
}
if (isset($_POST['bank_account'])) {
    $bank_account = $_POST['bank_account'];
}
if (isset($_POST['bank_id'])) {
    $bank_id = $_POST['bank_id'];
}
if (isset($_POST['adjust_amount'])) {
    $adjust_amount = $_POST['adjust_amount'];
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}

//echo $adjust_amount;return;

if ($recid <= 0) {
    if ($bank_account != '' && $bank_id != '') {
        $sql = "INSERT INTO bank_account_company (name,bank_account,bank_id)
           VALUES ('$account_name','$bank_account','$bank_id')";

        if ($result = $connect->query($sql)) {
            if($adjust_amount > 0){

                createtrans($connect, $bank_id,'Adjustment in',1,$adjust_amount,$user_id);
            }
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:bank_company.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:bank_company.php');
        }
    }

} else {
    $sql = "UPDATE bank_account_company SET name='$account_name',bank_account='$bank_account',bank_id='$bank_id'";
    $sql.=" WHERE id='$recid'";

    if ($result = $connect->query($sql)) {
        if($adjust_amount > 0){
            createtrans($connect, $recid,'Adjustment in',1,$adjust_amount,$user_id);
        }else if($adjust_amount < 0){
            //$adjust_amount;return;
            createtrans($connect, $recid,'Adjustment out',2,$adjust_amount,$user_id);
        }


        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:bank_company.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:bank_company.php');
    }
}

?>
