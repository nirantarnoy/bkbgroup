<?php
include("common/dbcon.php");
include("models/PromotionModel.php");
$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {

    $last_pro_name = getLastProName($id,$connect);
    $last_pro = getLastProDate($id,$connect);
    $last_pro_count = getProcount($id,$connect);
        array_push($data,[
            'promotion_date' => $last_pro,
            'promotion_get' => $last_pro_count,
            'promotion_name' => $last_pro_name
        ]);


    echo json_encode($data);
}else{
    echo json_encode($data);
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


?>
