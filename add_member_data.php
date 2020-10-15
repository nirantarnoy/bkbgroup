<?php
ob_start();
session_start();
include("common/dbcon.php");
date_default_timezone_set('Asia/Bangkok');

$account_id = '';
$name = '';
$dob = null;
$phone = '';
$id_number = '';
$bank_id = 0;
$bank_account = '';
$lv2 = 0;
$card_photo = '';
$bank_photo = '';
$status = 1;
$recid = 0;



if (isset($_POST['account_id'])) {
    $account_id = $_POST['account_id'];
}
if (isset($_POST['member_name'])) {
    $name = $_POST['member_name'];
}
if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
}
if (isset($_POST['id_number'])) {
    $id_number = $_POST['id_number'];
}
if (isset($_POST['bank_id'])) {
    $bank_id = $_POST['bank_id'];
}
if (isset($_POST['bank_account'])) {
    $bank_account = $_POST['bank_account'];
}
if (isset($_POST['is_level2'])) {
    $lv2 = $_POST['is_level2'];
}
if (isset($_POST['member_dob'])) {
    $dob = $_POST['member_dob'];
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}


if ($recid <= 0) {
    if ($name != '' && $phone != '' && $bank_account != '') {

        if(isset($_FILES['file_card'])){
            $errors = array();
            $file_name = $_FILES['file_card']['name'];
            $file_tmp =$_FILES['file_card']['tmp_name'];
         //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
            $card_photo = $file_name;
            move_uploaded_file($file_tmp,"uploads/idcard_photo/".$card_photo);
        }
        if(isset($_FILES['file_bank'])){
            $errors = array();
            $file_name = $_FILES['file_bank']['name'];
            $file_tmp =$_FILES['file_bank']['tmp_name'];
            //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
            $bank_photo = $file_name;
            move_uploaded_file($file_tmp,"uploads/bank_photo/".$bank_photo);
        }

        $m_dob = date('Y-d-m',strtotime($dob));
       // $active_date = date('Y-m-d H:m:i');
        $active_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO member (account_id,name,dob,id_number,phone,bank_id,bank_account,is_level2,id_card_photo,bank_photo,status,active_date)
           VALUES ('$account_id','$name','$m_dob','$id_number','$phone','$bank_id','$bank_account','$lv2','$card_photo','$bank_photo','$status','$active_date')";

        if ($result = $connect->query($sql)) {

            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:member.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:member.php');
        }
    }

} else {
    if(isset($_FILES['file_card'])){
        $errors = array();
        $file_name = $_FILES['file_card']['name'];
        $file_tmp =$_FILES['file_card']['tmp_name'];
        //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
        $card_photo = $file_name;
        move_uploaded_file($file_tmp,"uploads/idcard_photo/".$card_photo);
    }
    if(isset($_FILES['file_bank'])){
        $errors = array();
        $file_name = $_FILES['file_bank']['name'];
        $file_tmp =$_FILES['file_bank']['tmp_name'];
        //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
        $bank_photo = $file_name;
        move_uploaded_file($file_tmp,"uploads/bank_photo/".$bank_photo);
    }
    $m_dob = date('Y-d-m',strtotime($dob));
    $sql = "UPDATE member SET account_id='$account_id',dob='$m_dob', name='$name',phone='$phone',id_number='$id_number',bank_id='$bank_id',bank_account='$bank_account',is_level2='$lv2'";
    if($card_photo != ''){
        $sql.=",id_card_photo='$card_photo'";
    }
    if($bank_photo != ''){
        $sql.=",bank_photo='$bank_photo'";
    }
    $sql.=" WHERE id='$recid'";

    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:member.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:member.php');
    }
}

?>
