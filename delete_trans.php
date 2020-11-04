<?php
ob_start();
session_start();
include("common/dbcon.php");

$id = 0;
$trans_type = 0;

if(isset($_POST['recid'])){
    $id = $_POST['recid'];
}
//if(isset($_POST['trans_type'])){
//    $trans_type = $_POST['trans_type'];
//}

if($id > 0){
    $sql = "DELETE FROM member_account WHERE id=".$id;
    if ($result = $connect->query($sql)) {
      echo 1;
    } else {
      echo 0;
    }
}else{
    echo 0;
}


?>
