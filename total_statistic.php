<?php
//session_start();
include("common/dbcon.php");
include("models/PromotionModel.php");
include("models/BankModel.php");

$total_member = 0;
$total_cash_in = 0;
$total_cash_out = 0;
$total_net_win = 0;
$total_promotion_get = 0;

$query = "SELECT SUM(cash_in)as cash_in,SUM(cash_out) as cash_out,SUM(net_win) as net_win FROM member_account";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach ($result as $row) {
    $total_cash_in = number_format($row['cash_in'], 0);
    $total_cash_out = number_format($row['cash_out'], 0);
    $total_net_win = number_format($row['net_win'], 0);
}

$query2 = "SELECT COUNT(*) as cnt FROM member";
$statement2 = $connect->prepare($query2);
$statement2->execute();
$result2 = $statement2->fetchAll();

foreach ($result2 as $row2) {
    $total_member = number_format($row2['cnt'], 0);
}

$query3 = "SELECT COUNT(*) as cnt FROM member_account WHERE cash_in > 0 AND promotion_id > 0";
$statement3 = $connect->prepare($query3);
$statement3->execute();
$result3 = $statement3->fetchAll();

foreach ($result3 as $row3) {
    $total_promotion_get = number_format($row3['cnt'], 0);
}


?>
