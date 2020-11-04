<?php
session_start();
include("common/dbcon.php");
include("models/PromotionModel.php");
include("models/BankModel.php");
include("models/UserModel.php");

$id = 0;
$data = 0;
$from_date = null;
$to_date = null;
$f_date = null;
$t_date = null;

$promotion_id = 0;
$bank_id = 0;

if (isset($_POST['from_date'])) {
    $from_date = $_POST['from_date'];
}
if (isset($_POST['to_date'])) {
    $to_date = $_POST['to_date'];
}

if (isset($_POST['promotion_id'])) {
    $promotion_id = $_POST['promotion_id'];
}

if($from_date != '' && $to_date !=''){
    $f_date = date('Y-m-d H:m:i', strtotime($_POST["from_date"]));
    $t_date = date('Y-m-d H:m:i',strtotime($_POST["to_date"]));
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id == 0) {
    $query = "SELECT SUM(balance)as amt FROM bank_account_company";
    if($promotion_id != 0){
        $query.= " AND promotion_id = '$promotion_id'";
    }
    if ($f_date != null && $t_date != null) {
        $query .= " AND (trans_date >='$f_date' AND trans_date <='$t_date') ";
    }
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
       $data = number_format($row['amt'],2);
    }

    echo $data;
}else{
    echo $data;
}


?>
