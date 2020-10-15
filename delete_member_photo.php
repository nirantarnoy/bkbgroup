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
    $sql = "UPDATE member SET id_card_photo='' WHERE id='$id' AND id_card_photo='$delete_photo'";
    if ($result = $connect->query($sql)) {
        unlink("uploads/idcard_photo/".$delete_photo);
        echo 1;
    } else {
        echo 0;
    }
}else{
    echo 0;
}


?>
