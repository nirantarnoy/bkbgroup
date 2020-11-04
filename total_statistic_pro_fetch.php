<?php
//session_start();
include("common/dbcon.php");
include("models/PromotionModel.php");
include("models/BankModel.php");

$total_promotion_get = 0;
$data = [];

$promotion_id = 0;

if (isset($_POST['promotion_id'])) {
    $promotion_id = $_POST['promotion_id'];
}

if($promotion_id > 0){
    $query = "SELECT COUNT(*) as cnt FROM member_account WHERE cash_in > 0 AND promotion_id='$promotion_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $total_promotion_get = number_format($row['cnt'], 0);
    }

    array_push($data,[
        'total_get' => $total_promotion_get,
    ]);

    echo json_encode($data);


}
else{
    json_encode($data);
}


?>
