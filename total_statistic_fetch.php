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
$data = [];


$from_date = null;
$to_date = null;
$f_date = null;
$t_date = null;

$promotion_id = 0;
$member_type = 0;

if (isset($_POST['from_date'])) {
    $from_date = $_POST['from_date'];
}
if (isset($_POST['to_date'])) {
    $to_date = $_POST['to_date'];
}

if (isset($_POST['promotion_id'])) {
    $promotion_id = $_POST['promotion_id'];
}

if (isset($_POST['member_group_id'])) {
    $member_type = $_POST['member_group_id'];
}

if($from_date != '' && $to_date !=''){
//    $ff_date = null;
//    $tt_date = null;
//    $a = explode('/',$from_date);
//    if(count($a) >0){
//        $ff_date = $a[2].'/'.$a[1].'/'.$a[0];
//    }
//    $b = explode('/',$to_date);
//    if(count($b) >0){
//        $tt_date = $b[2].'/'.$b[1].'/'.$b[0];
//    }
//    $f_date = date('Y-m-d', strtotime($ff_date));
//    $t_date = date('Y-m-d', strtotime($tt_date));
//    $f_date = date('Y-m-d H:m:i', strtotime($_POST["from_date"]));
//    $t_date = date('Y-m-d H:m:i',strtotime($_POST["to_date"]));
    $f_date = date('Y-m-d H:i:s',strtotime($from_date));
    $t_date = date('Y-m-d H:i:s',strtotime($to_date));
}


//$query = "SELECT SUM(cash_in)as cash_in,SUM(cash_out) as cash_out,SUM(net_win) as net_win FROM member_account WHERE id > 0 ";
// if($promotion_id !='' || $promotion_id > 0){
//    $query .= " AND promotion_id = '$promotion_id'";
//}
//if ($f_date != null && $t_date != null) {
//    $query .= " AND (trans_date >='$f_date' AND trans_date <='$t_date') ";
//}
//$query.= " GROUP BY member_id";

$query = '';
if($member_type == 0){
    $query = "SELECT SUM(cash_in) as cash_in,SUM(cash_out) as cash_out, SUM(net_win) as net_win FROM member_account WHERE id > 0";
    if($promotion_id  > 0)
    {
        $query.= " AND promotion_id='$promotion_id'";
    }
    if($f_date != '' && $t_date != '')
    {
        $query.= " AND (trans_date >= '$f_date' AND trans_date <='$t_date')";
    }
}
if($member_type == 1){
    $query = "SELECT SUM(member_account.cash_in) as cash_in,SUM(member_account.cash_out) as cash_out, SUM(member_account.net_win) as net_win FROM member_account INNER JOIN member ON member_account.member_id=member.id WHERE member_account.id > 0 AND member.member_type is null";
    if($promotion_id  > 0)
    {
        $query.= " AND member_account.promotion_id='$promotion_id'";
    }
    if($f_date != '' && $t_date != '')
    {
        $query.= " AND (member_account.trans_date >= '$f_date' AND member_account.trans_date <='$t_date')";
    }
}
if($member_type == 2){
    $query = "SELECT SUM(member_account.cash_in) as cash_in,SUM(member_account.cash_out) as cash_out, SUM(member_account.net_win) as net_win FROM member_account INNER JOIN member ON member_account.member_id=member.id WHERE member_account.id > 0 AND member.member_type = 'SKM'";
    if($promotion_id  > 0)
    {
        $query.= " AND member_account.promotion_id='$promotion_id'";
    }
    if($f_date != '' && $t_date != '')
    {
        $query.= " AND (member_account.trans_date >= '$f_date' AND member_account.trans_date <='$t_date')";
    }
}


//$query.= " GROUP BY member_id";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach ($result as $row) {
    $total_cash_in = number_format($row['cash_in'], 0);
    $total_cash_out = number_format($row['cash_out'], 0);
    $total_net_win = number_format($row['net_win'], 0);
}

array_push($data,[
   'total_cash_in' => $total_cash_in,
   'total_cash_out' => $total_cash_out,
   'total_net_win' => $total_net_win,
]);

echo json_encode($data);

//$query3 = "SELECT COUNT(*) as cnt FROM member_account WHERE cash_in > 0 AND promotion_id > 0";
//$statement3 = $connect->prepare($query3);
//$statement3->execute();
//$result3 = $statement3->fetchAll();
//
//foreach ($result3 as $row3) {
//    $total_promotion_get = number_format($row3['cnt'], 0);
//}


?>
