<?php
//date_default_timezone_set('Asia/Rangoon');
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

$member_id = '';
$deposit = 0;
$withdraw = 0;
$promotion = 0;
$turnover = 0;

$recid = 0;


if (isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];
}
if (isset($_POST['deposit'])) {
    $deposit = $_POST['deposit'];
}
if (isset($_POST['withdraw'])) {
    $withdraw = $_POST['withdraw'];
}
if (isset($_POST['promotion_id'])) {
    $promotion = $_POST['promotion_id'];
}
if (isset($_POST['turnover'])) {
    $turnover = $_POST['turnover'];
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}


if ($recid <= 0) {
    if ($member_id > 0) {
        $t_date = date('Y-m-d H:i:s');
        $net_win = $deposit - $withdraw;
        $created_at = strtotime($t_date);
        $sql = "INSERT INTO member_account (trans_date,member_id,promotion_id,cash_in,cash_out,net_win,turnover,created_at)
           VALUES ('$t_date','$member_id','$promotion','$deposit','$withdraw','$net_win','$turnover','$created_at')";

        if ($result = $connect->query($sql)) {
            echo 1;
        } else {
            echo 0;
        }
    }else{
        echo 0;
    }

}else{
    echo 0;
}
?>
