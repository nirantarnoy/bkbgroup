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
    $sql = "UPDATE product SET photo='' WHERE id='$id' AND photo='$delete_photo'";
    if ($result = $connect->query($sql)) {
        unlink("uploads/product_photo/".$delete_photo);
//        $_SESSION['msg-success'] = 'Deleted data successfully';
//        header('location:product.php');
        echo 1;
    } else {
        echo 0;
       // $_SESSION['msg-error'] = 'Delete data error';
       // header('location:product.php');
    }
}else{
    echo 0;
//    echo $id;return;
//    $_SESSION['msg-error'] = 'Delete data error';
//    header('location:product.php');
}


?>
