<?php
ob_start();
session_start();
include("common/dbcon.php");
include("models/BankTransModel.php");

$id = 0;
$user_id  = 0;
$trans_type = 0;
if(isset($_SESSION['userid'])){
    $user_id = $_SESSION['userid'];
}
if(isset($_POST['recid'])){
    $id = $_POST['recid'];
}
//if(isset($_POST['trans_type'])){
//    $trans_type = $_POST['trans_type'];
//}

if($id > 0){
    $account_data = getaccountinfo($connect, $id);
    $sql = "DELETE FROM member_account WHERE id=".$id;
    if ($result = $connect->query($sql)) {
        if(count($account_data) > 0){
            if ($account_data[0]['withdraw'] > 0) {
                createtrans($connect, $account_data[0]['bank_id'], 'Delete withdraw member account', 1, $account_data[0]['withdraw'], $user_id);
            }
            if ($account_data[0]['deposit'] > 0) {
                createtrans($connect, $account_data[0]['bank_id'], 'Delete deposit member account', 2, $account_data[0]['deposit'], $user_id);
            }
        }
      echo 1;
    } else {
      echo 0;
    }
}else{
    echo 0;
}


function getaccountinfo($connect, $id){
    $data = [];
    $sql = "SELECT * FROM member_account WHERE id='$id'";
    $statement = $connect->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            $bank_id = $row['bank_account_id'];
            $qty_withdraw = $row['cash_out'];
            $qty_deposit = $row['cash_in'];

            array_push($data,['bank_id'=>$bank_id,'withdraw'=>$qty_withdraw,'deposit'=>$qty_deposit]);

//            if($row['withdraw'] > 0){
//                createtrans($connect, $bank_id,'Delete withdraw member account',1,$qty_withdraw,$user_id);
//            }
//            if($row['deposit'] > 0){
//                createtrans($connect, $bank_id,'Delete deposit member account',2,$qty_deposit,$user_id);
//            }
        }
        return $data;
    }else{
        return $data;
    }
}


?>
