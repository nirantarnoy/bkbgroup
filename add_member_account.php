<?php
ob_start();
session_start();
//date_default_timezone_set('Asia/Rangoon');
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");
include("models/LogsModel.php");
include("models/MemberModel.php");
include("models/BankTransModel.php");

$member_id = 0;
$deposit = 0;
$withdraw = 0;
$promotion = 0;
$turnover = 0;
$userid = 0;
$action_type = '';
$bank_id = 0;

$recid = 0;

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
}


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
if (isset($_POST['action_type'])) {
    $action_type = $_POST['action_type'];
}
if (isset($_POST['bank_id'])) {
    $bank_id = $_POST['bank_id'];
}


if ($recid <= 0 && $action_type == 'create') {
    if ($member_id > 0  && ($promotion >0 || $deposit > 0 || $withdraw >0 || $turnover > 0)) {
        $t_date = date('Y-m-d H:i:s');
        $net_win = $deposit - $withdraw;
        $created_at = strtotime($t_date);
        $sql = "INSERT INTO member_account (trans_date,member_id,promotion_id,cash_in,cash_out,net_win,turnover,bank_account_id,created_at,created_by)
           VALUES ('$t_date','$member_id','$promotion','$deposit','$withdraw','$net_win','$turnover','$bank_id','$created_at','$userid')";

        if ($result = $connect->query($sql)) {
            if($withdraw >0 ){
                createtrans($connect, $bank_id,'Member withdraw',2,$qty,$userid);
               // transOutUpdate($connect, $bank_id, $withdraw);
            }
            if($deposit > 0){
                createtrans($connect, $bank_id,'Member deposit',1,$qty,$userid);
               // transInUpdate($connect, $bank_id, $deposit);
            }
            createlogs($connect,$userid,'insert','accounting',getMembername($connect,$member_id));
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
