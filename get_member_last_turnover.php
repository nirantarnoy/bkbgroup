<?php
include("common/dbcon.php");
include("models/PromotionModel.php");
$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {

    $last_turnover = getLastTurnoverAmt($id,$connect);
    $last_turnover_date = getLastTurnoverDate($id,$connect);
    $count_turnover = getTurnovercount($id,$connect);
        array_push($data,[
            'turnover_amt' => number_format($last_turnover),
            'turnover_date' => $last_turnover_date,
            'turnover_get' => $count_turnover,
        ]);


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


?>
