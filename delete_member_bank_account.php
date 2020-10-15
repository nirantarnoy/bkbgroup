<?php
ob_start();
session_start();
include("common/dbcon.php");

$id = 0;
$delete_photo = '';

if(isset($_POST['delete_photo_id'])){
    $id = $_POST['delete_photo_id'];
}
if(isset($_POST['delete_photo'])){
    $delete_photo = trim($_POST['delete_photo']);
}

if($id > 0){
    $sql = "UPDATE member SET bank_photo='' WHERE id='$id' AND bank_photo='$delete_photo'";
    if ($result = $connect->query($sql)) {
        unlink("uploads/bank_photo/".$delete_photo);
        echo 1;
    } else {
        echo 0;
    }
}else{
    echo 0;
}


?>
