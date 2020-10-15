<?php
include("common/dbcon.php");
include("models/PromotionModel.php");

$member_id = '';
$promotion_id = 0;
$from_date = null;
$to_date = null;
$data = [];

if (isset($_POST['promotion_id'])) {
    $promotion_id = $_POST['promotion_id'];
}

if (isset($_POST['from_date'])) {
    $from_date = $_POST['from_date'];
}
if (isset($_POST['to_date'])) {
    $to_date = $_POST['to_date'];
}

if (isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];
}

if ($member_id) {
    $ff_date = null;
    $tt_date = null;
    $a = explode('/',$from_date);
    if(count($a) >0){
        $ff_date = $a[2].'/'.$a[1].'/'.$a[0];
    }
    $b = explode('/',$to_date);
    if(count($b) >0){
        $tt_date = $b[2].'/'.$b[1].'/'.$b[0];
    }
    $f_date = date('Y-m-d', strtotime($ff_date));
    $t_date = date('Y-m-d', strtotime($tt_date));

    $last_promotion_name = getLastPromotionName($member_id, $promotion_id, $connect, $f_date, $t_date);
    $last_promotion = getLastPromotion($member_id, $promotion_id, $connect, $f_date, $t_date);
    $last_turnover = getLastTurnover($member_id, $connect);
    $last_turnover_date = getLastDateTurnover($member_id, $connect);

    $promotion_cnt = getPromotioncount($member_id, $promotion_id, $connect, $f_date, $t_date);
    $turnover_cnt = getTurnovercount($member_id, $connect);

    $cash = getCash($member_id, $promotion_id, $connect, $f_date, $t_date);
    $cash_in = 0;
    $cash_out = 0;
    $net_win = 0;
    if ($cash != null) {
        $cash_in = $cash[0]['cash_in'] == null?0:$cash[0]['cash_in'];
        $cash_out = $cash[0]['cash_out'] == null?0:$cash[0]['cash_out'];
        $net_win = $cash[0]['net_win'] == null?0:$cash[0]['net_win'];
    }


    array_push($data, [
            'last_promotion_name' => $last_promotion_name,
            'last_promotion' => $last_promotion,
            'last_turnover' => number_format($last_turnover),
            'last_turnover_date' => $last_turnover_date,
            'promotion_cnt' => $promotion_cnt,
            'turnover_cnt' => $turnover_cnt,
//            'cash_in' => $cash_in,
//            'cash_out' => $cash_out,
//            'net_win' => $net_win,
        ]
    );
    echo json_encode($data);
} else {
    echo json_encode($data);
}


function getCash($member_id, $promotion_id, $connect, $f_date, $t_date)
{
    $data = [];
    $query = "SELECT SUM(cash_in) as cash_in,SUM(cash_out) as cash_out,SUM(net_win) as net_win FROM member_account WHERE member_id='$member_id'";
    if ($promotion_id > 0) {
        $query .= " AND promotion_id='$promotion_id' ";
    }
    if ($f_date != null && $t_date != null) {
        $query .= " AND (date(trans_date) >='$f_date' AND date(trans_date) <='$t_date') ";
    }
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        array_push($data, ['cash_in' => $row['cash_in'], 'cash_out' => $row['cash_out'], 'net_win' => $row['net_win']]);
    }

    return $data;
}


function getLastPromotion($member_id, $promotion_id, $connect, $f_date, $t_date)
{
    $last_date = null;
    $query = "SELECT trans_date FROM member_account WHERE member_id='$member_id' and cash_in > 0 ";
    if($promotion_id > 0){
        $query.=" AND promotion_id='$promotion_id'";
    }
    if ($f_date != null && $t_date != null) {
        $query .= " AND (date(trans_date) >='$f_date' AND date(trans_date) <='$t_date') ";
    }
    $query.= " ORDER BY id DESC LIMIT 1";


    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_date = $row['trans_date'];
    }

    return $last_date;
}
function getLastPromotionName($member_id, $promotion_id, $connect, $f_date, $t_date)
{
    $last_date = null;
    $query = "SELECT promotion_id FROM member_account WHERE member_id='$member_id' and cash_in > 0 ";
    if($promotion_id > 0){
        $query.=" AND promotion_id='$promotion_id'";
    }
    if ($f_date != null && $t_date != null) {
        $query .= " AND (date(trans_date) >='$f_date' AND date(trans_date) <='$t_date') ";
    }
    $query.= " ORDER BY id DESC LIMIT 1";


    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_date = getPromotionname($connect,$row['promotion_id']);
    }

    return $last_date;
}

function getLastDateTurnover($member_id, $connect)
{
    $last_date = null;
    $query = "SELECT trans_date FROM member_account WHERE member_id='$member_id' and turnover > 0 ORDER BY id DESC LIMIT 1";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_date = $row['trans_date'];
    }

    return $last_date;
}

function getLastTurnover($member_id, $connect)
{
    $last_turnover = 0;
    $query = "SELECT turnover FROM member_account WHERE member_id='$member_id' and turnover > 0 ORDER BY id DESC LIMIT 1 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_turnover = $row['turnover'];
    }

    return $last_turnover;
}

function getPromotioncount($member_id, $promotion_id, $connect, $f_date, $t_date)
{
    $cnt = 0;
    $query = "SELECT count(*) as cnt FROM member_account WHERE member_id='$member_id' and cash_in > 0 ";
    if($promotion_id > 0){
        $query.=" AND promotion_id='$promotion_id'";
    }
    if ($f_date != null && $t_date != null) {
        $query .= " AND (date(trans_date) >='$f_date' AND date(trans_date) <='$t_date') ";
    }
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $cnt = $row['cnt'];
    }

    return $cnt;
}

function getTurnovercount($member_id, $connect)
{
    $cnt = 0;
    $query = "SELECT count(*) as cnt FROM member_account WHERE member_id='$member_id' and turnover > 0 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $cnt = $row['cnt'];
    }

    return $cnt;
}

?>
