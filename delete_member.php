<?php
ob_start();
session_start();
include("common/dbcon.php");
include("models/LogsModel.php");
include("models/MemberModel.php");

$id = 0;
$userid = 0;

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
}
if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];
}

if($id > 0){
    $sql = "DELETE FROM member WHERE id=".$id;
    if ($result = $connect->query($sql)) {
        $sql2 = "DELETE FROM member_account WHERE member_id='$id'";
        if ($result2 = $connect->query($sql2)) {
            //createlogs($connect,$userid,'delete','member',getMembername($id));
        }
        createlogs($connect,$userid,'delete','member',getMembername($connect,$id));
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
