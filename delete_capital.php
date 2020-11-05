<?php
ob_start();
session_start();
include("common/dbcon.php");
include("models/BankTransModel.php");

$id = 0;
$qty = 0;
$user_id = 0;

if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
}
if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];
}
if(isset($_POST['delete_qty'])){
    $qty = $_POST['delete_qty'];
}

if($qty == ''){
    $qty = 0;
}

if($id > 0){
    $bank_id = getcapitalInfo($connect, $id);
   // echo $bank_id;return;
    $sql = "DELETE FROM capital WHERE id=".$id;
    if ($result = $connect->query($sql)) {
        createtrans($connect, $bank_id,'Delete capital',2,$qty,$user_id);
        $_SESSION['msg-success'] = 'Deleted data successfully';
        header('location:capital.php');
    } else {
        $_SESSION['msg-error'] = 'Delete data error';
        header('location:capital.php');
    }
}else{
    echo $id;return;
    $_SESSION['msg-error'] = 'Delete data error';
    header('location:capital.php');
}

function getcapitalInfo($connect, $id){
    $query = "SELECT * FROM capital WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['company_bank_account_id'];
        }
    }else{
        return 0;
    }
}


?>
