<?php
ob_start();
session_start();
include("common/dbcon.php");

$name = '';
$description = '';
$recid = 0;

$is_member = 0;
$is_accounting = 0;
$is_promotion = 0;
$is_capital = 0;
$is_bank = 0;
$is_user = 0;
$is_position = 0;
$is_all = 0;


if (isset($_POST['bank_name'])) {
    $name = $_POST['bank_name'];
}
if (isset($_POST['description'])) {
    $description = $_POST['description'];
}

if (isset($_POST['is_member'])) {
    if($_POST['is_member'] == 'on'){
        $is_member = 1;
    }
}
if (isset($_POST['is_accounting'])) {
    if($_POST['is_accounting'] == 'on'){
        $is_accounting = 1;
    }
}
if (isset($_POST['is_promotion'])) {
    if($_POST['is_promotion'] == 'on'){
        $is_promotion = 1;
    }
}
if (isset($_POST['is_capital'])) {
    if($_POST['is_capital'] == 'on'){
        $is_capital = 1;
    }
}
if (isset($_POST['is_bank'])) {
    if($_POST['is_bank'] == 'on'){
        $is_bank = 1;
    }
}
if (isset($_POST['is_user'])) {
    if($_POST['is_user'] == 'on'){
        $is_user = 1;
    }
}
if (isset($_POST['is_position'])) {
    if($_POST['is_position'] == 'on'){
        $is_position = 1;
    }
}
if (isset($_POST['is_all'])) {
    if($_POST['is_all'] == 'on'){
        $is_all = 1;
    }
}


if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}

//print_r($_POST);return;

if ($recid <= 0) {
    if ($name != '') {
        $sql = "INSERT INTO position_user (name,description,is_member,is_accounting,is_promotion,is_capital,is_bank,is_user,is_position,is_all)
           VALUES ('$name','$description','$is_member','$is_accounting','$is_promotion','$is_capital','$is_bank','$is_user','$is_position','$is_all')";
        if ($result = $connect->query($sql)) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:position.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:position.php');
        }
    }

} else {
    $sql = "UPDATE position_user SET name='$name',description='$description',is_member='$is_member',is_accounting='$is_accounting',is_promotion='$is_promotion',is_capital='$is_capital',is_bank='$is_bank',is_user='$is_user',is_position='$is_position',is_all='$is_all'";
    $sql.=" WHERE id='$recid'";

    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:position.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:position.php');
    }
}

?>
