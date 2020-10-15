<?php
include("common/dbcon.php");
include("models/PromotionModel.php");
$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {

    $cash_total = getCash($id,$connect);
        array_push($data,[
            'cash_in' => $cash_total[0]['cash_in'],
            'cash_out' => $cash_total[0]['cash_out'],
            'net_win' => $cash_total[0]['net_win'],
        ]);


    echo json_encode($data);
}else{
    echo json_encode($data);
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
