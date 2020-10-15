<?php
include("common/dbcon.php");
include("models/PromotionModel.php");
$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {
    $query = "SELECT * FROM member WHERE id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
//    foreach ($result as $row) {
//       array_push($data,['id'=>$row['id'],'display_name'=>$row['display_name'],'username'=>$row['username'],'status'=>$row['status'],'use_start'=>$row['use_start'],'use_end'=>$row['use_end'],
//           'branch_price'=>$row['branch_price'],'is_dash'=>$row['is_dashboard'],'is_prod'=>$row['is_product']
//           ,'is_return'=>$row['is_return'],'is_history'=>$row['is_history'],'is_customer'=>$row['is_customer']
//           ,'is_tool'=>$row['is_tool'],'is_user'=>$row['is_user'],'is_all'=>$row['is_all']]);
//    }
    foreach ($result as $row) {
        $last_turnover = getLastTurnoverAmt($id,$connect);
        $last_turnover_date = getLastTurnoverDate($id,$connect);
        $count_turnover = getTurnovercount($id,$connect);

        $last_pro_name = getLastProName($id,$connect);
        $last_pro = getLastProDate($id,$connect);
        $last_pro_count = getProcount($id,$connect);

        $cash_total = getCash($id,$connect);

        array_push($data,[
            'id'=>$row['id'],
            'account_id'=>$row['account_id'],
            'name'=>$row['name'],
            'dob'=> $row['dob'] != null ?date("d/m/Y",strtotime($row['dob'])):date('d/m/Y'),
            'phone'=>$row['phone'],
            'id_number'=>$row['id_number'],
            'bank_id'=>$row['bank_id'],
            'bank_account'=>$row['bank_account'],
            'is_level2'=>$row['is_level2'],
            'card_photo'=>$row['id_card_photo'],
            'bank_photo'=>$row['bank_photo'],
            'turnover_amt' => number_format($last_turnover),
            'turnover_date' => $last_turnover_date,
            'turnover_get' => $count_turnover,
            'promotion_date' => $last_pro,
            'promotion_get' => $last_pro_count,
            'promotion_name' => $last_pro_name,
            'cash_in' => $cash_total[0]['cash_in'],
            'cash_out' => $cash_total[0]['cash_out'],
            'net_win' => $cash_total[0]['net_win'],
        ]);
    }

    echo json_encode($data);
}else{
    echo json_encode($data);
}

function getLastTurnoverAmt($member_id, $connect)
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
function getLastTurnoverDate($member_id, $connect)
{
    $last_turnover = '';
    $query = "SELECT trans_date FROM member_account WHERE member_id='$member_id' and turnover > 0 ORDER BY id DESC LIMIT 1 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_turnover = $row['trans_date'];
    }

    return $last_turnover;
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


function getLastProName($member_id, $connect)
{
    $last_turnover = '';
    $query = "SELECT promotion_id FROM member_account WHERE member_id='$member_id' and cash_in > 0 and promotion_id > 0 ORDER BY id DESC LIMIT 1 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_turnover = getPromotionname($connect,$row['promotion_id']);
    }

    return $last_turnover;
}
function getLastProDate($member_id, $connect)
{
    $last_turnover = '';
    $query = "SELECT trans_date FROM member_account WHERE member_id='$member_id' and cash_in > 0 and promotion_id > 0 ORDER BY id DESC LIMIT 1 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_turnover = $row['trans_date'];
    }

    return $last_turnover;
}
function getProcount($member_id, $connect)
{
    $cnt = 0;
    $query = "SELECT count(*) as cnt FROM member_account WHERE member_id='$member_id' and cash_in > 0 and promotion_id > 0 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $cnt = $row['cnt'];
    }

    return $cnt;
}

function getCash($member_id, $connect)
{
    $data = [];
    $query = "SELECT SUM(cash_in) as cash_in,SUM(cash_out) as cash_out,SUM(net_win) as net_win FROM member_account WHERE member_id='$member_id'";
//    if ($promotion_id > 0) {
//        $query .= " AND promotion_id='$promotion_id' ";
//    }
//    if ($f_date != null && $t_date != null) {
//        $query .= " AND (date(trans_date) >='$f_date' AND date(trans_date) <='$t_date') ";
//    }
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        array_push($data, ['cash_in' => number_format($row['cash_in']), 'cash_out' => number_format($row['cash_out']), 'net_win' => number_format($row['net_win'])]);
    }

    return $data;
}


?>
