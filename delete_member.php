<?php
ob_start();
session_start();
include("common/dbcon.php");

$id = 0;

if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];
}

if($id > 0){
    $sql = "DELETE FROM member WHERE id=".$id;
    if ($result = $connect->query($sql)) {
        $sql2 = "DELETE FROM member_account WHERE member_id='$id'";
        if ($result2 = $connect->query($sql2)) {

        }
        $_SESSION['msg-success'] = 'Deleted data successfully';
        header('location:member.php');
    } else {
        $_SESSION['msg-error'] = 'Delete data error';
        header('location:member.php');
    }
}else{
    //echo $id;return;
    $_SESSION['msg-error'] = 'Delete data error';
    header('location:member.php');
}


?>
