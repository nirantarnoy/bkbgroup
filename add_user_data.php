<?php
ob_start();
session_start();
include("common/dbcon.php");

$displayname = '';
$username = '';
$password = '';
$branch = '';
$recid = 0;
$position = 0;


$s_time = '00:00';
$n_time = '00:00';
$is_member = 0;
$is_accounting = 0;
$is_promotion = 0;
$is_capital = 0;
$is_bank = 0;
$is_user = 0;
$is_all = 0;


if (isset($_POST['displayname'])) {
    $displayname = $_POST['displayname'];
}
if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
if (isset($_POST['branch'])) {
    $branch = $_POST['branch'];
}
if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}
if (isset($_POST['position_id'])) {
    $position = $_POST['position_id'];
}

if (isset($_POST['start_time'])) {
    $s_time = $_POST['start_time'];
}
if (isset($_POST['end_time'])) {
    $n_time = $_POST['end_time'];
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
if (isset($_POST['is_all'])) {
    if($_POST['is_all'] == 'on'){
        $is_all = 1;
    }
}
if (isset($_POST['branch_price'])) {
    $branch_price = $_POST['branch_price'];
}

if ($recid <= 0) {
    if ($username != '' && $password != '') {
        $newpass = md5($password);
//        $sql = "INSERT INTO user (display_name,username,password,branch,usergroup,use_start,use_end,is_dashboard,is_product,is_return,is_history,is_customer,is_tool,is_user,branch_price,is_all)
//           VALUES ('$username','$newpass','$displayname','$branch','user','$s_time','$n_time','$is_dash','$is_prod','$is_return','$is_history','$is_customer','$is_tool','$is_user','$branch_price','$is_all')";
        $sql = "INSERT INTO user (display_name,username,password,position_id,status)
           VALUES ('$displayname','$username','$newpass','$position',1)";

        if ($result = $connect->query($sql)) {
            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
            header('location:user.php');
        } else {
            $_SESSION['msg-error'] = 'พบข้อผิดพลาด';
            header('location:user.php');
        }
    }

} else {
    $sql = "UPDATE user SET display_name='$displayname',position_id='$position'";
    $sql.=" WHERE id='$recid'";

    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
        header('location:user.php');
    } else {
        $_SESSION['msg-error'] = 'พบข้อผิดพลาด';
        header('location:user.php');
    }
}

?>
