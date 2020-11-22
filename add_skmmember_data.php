<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');

include("common/dbcon.php");
include("models/LogsModel.php");
include("models/MemberModel.php");

$userid = 0;
$account_id = '';
$name = '';
$dob_origin = null;
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
$m_dob = null;
$action_type = '';

$active_date = date('Y-m-d H:i:s');

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
}


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
    $dob_origin = explode('/',$_POST['member_dob']);
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}
if (isset($_POST['action_type'])) {
    $action_type = $_POST['action_type'];
}

if(count($dob_origin) >1){
    $dob = $dob_origin[2].'/'.$dob_origin[1].'/'.$dob_origin[0];
}
$m_dob = date('Y-m-d',strtotime($dob));
//echo $m_dob;return;

if ($recid <= 0 && $action_type == 'create') {
    if ($name != '' && $phone != '' && $bank_account != '') {

        if(isset($_FILES['file_card'])){
            $errors = array();
            $file_name = $_FILES['file_card']['name'];
            $file_tmp =$_FILES['file_card']['tmp_name'];
            $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
//            echo basename($_FILES['file_card']['name']);return;
            if($file_ext != '') {
                $card_photo = time() . '.' . $file_ext;
            }
            move_uploaded_file($file_tmp,"uploads/idcard_photo/".$card_photo);
        }
        if(isset($_FILES['file_bank'])){
            $errors = array();
            $file_name = $_FILES['file_bank']['name'];
            $file_tmp =$_FILES['file_bank']['tmp_name'];
            $file_ext=strtolower(end(explode('.',$_FILES['file_bank']['name'])));
            if($file_ext != '') {
                $bank_photo = time() . '.' . $file_ext;
            }
            move_uploaded_file($file_tmp,"uploads/bank_photo/".$bank_photo);
        }

        //$m_dob = date('Y-m-d',strtotime($dob));
       // $active_date = date('Y-m-d H:m:i');

        $sql = "INSERT INTO member (account_id,name,dob,id_number,phone,bank_id,bank_account,is_level2,id_card_photo,bank_photo,status,active_date,created_by,member_type)
           VALUES ('$account_id','$name','$m_dob','$id_number','$phone','$bank_id','$bank_account','$lv2','$card_photo','$bank_photo','$status','$active_date','$userid','SKM')";

        if ($result = $connect->query($sql)) {
            createlogs($connect,$userid,'insert','member',$name);
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:skmmember.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:skmmember.php');
        }
    }

} else if($action_type == 'update') {
    if(isset($_FILES['file_card'])){
        $errors = array();
        $file_name = $_FILES['file_card']['name'];
        $file_tmp =$_FILES['file_card']['tmp_name'];
        $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
        //echo $file_ext;return;
        if($file_ext != ''){
            $card_photo = time().'.'.$file_ext;
        }
        move_uploaded_file($file_tmp,"uploads/idcard_photo/".$card_photo);
    }
    if(isset($_FILES['file_bank'])){
        $errors = array();
        $file_name = $_FILES['file_bank']['name'];
        $file_tmp =$_FILES['file_bank']['tmp_name'];
        $file_ext=strtolower(end(explode('.',$_FILES['file_bank']['name'])));
        if($file_ext != '') {
            $bank_photo = time() . '.' . $file_ext;
        }
        move_uploaded_file($file_tmp,"uploads/bank_photo/".$bank_photo);
    }

    //$m_dob = date('Y-m-d',strtotime($dob));
   // echo  $m_dob;return;
    $sql = "UPDATE member SET account_id='$account_id',dob='$m_dob', name='$name',phone='$phone',id_number='$id_number',bank_id='$bank_id',bank_account='$bank_account',is_level2='$lv2'";
    if($card_photo != ''){
        //echo $card_photo;return;
        $sql.=",id_card_photo='$card_photo'";
    }
    if($bank_photo != ''){
        $sql.=",bank_photo='$bank_photo'";
    }
    $sql.=" WHERE id='$recid'";

    if ($result = $connect->query($sql)) {
        createlogs($connect,$userid,'update','member',getMembername($connect,$recid));
        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:skmmember.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:skmmember.php');
    }
}

?>
