<?php
ob_start();
session_start();
if(empty($_SESSION['userid'])){
    header('location:loginpage.php');
}

include 'common/dbcon.php';

$old_pwd = '';
$password = '';
$userid = 0;

if(!empty($_POST['old_pwd'])){
    $old_pwd = md5($_POST['old_pwd']);
}
if(!empty($_POST['new_pwd'])){
    $password = md5($_POST['new_pwd']);
}
//if(!empty($_POST['user_id'])){
    $userid = $_SESSION['userid'];
//}

//echo $userid;return;


$sqlx = "SELECT * FROM user WHERE id='$userid' and password='$old_pwd'";

$statement = $connect->prepare($sqlx);
$statement->execute();
$filtered_rows = $statement->rowCount();
if($filtered_rows){
    $sql = "UPDATE user SET password='$password' WHERE id='$userid'";
    $res = $connect->query($sql);
    if($res){
        header('location:logout.php');
    }else{
        header('location:changepwdpage.php');
    }
}else{
    $_SESSION['msgerr'] = 'รหัสผ่านเดิมไม่ถูกต้อง';
    header('location:changepwdpage.php');
}


?>
