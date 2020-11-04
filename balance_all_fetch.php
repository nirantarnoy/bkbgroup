<?php
session_start();
include("common/dbcon.php");
include("models/PromotionModel.php");
include("models/BankModel.php");
include("models/UserModel.php");

$id = 0;
$data = 0;

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id == 0) {
    $query = "SELECT SUM(balance)as amt FROM bank_account_company";

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
