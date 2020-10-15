<?php
include("common/dbcon.php");
$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {
    $query = "SELECT SUM(cash_in) as cash_in,SUM(cash_out) as cash_out FROM member_account WHERE member_id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        array_push($data,['deposit'=>$row['cash_in'],'withdraw'=>$row['cash_out']]);
    }

    echo json_encode($data);
}else{
    echo json_encode($data);
}


?>
