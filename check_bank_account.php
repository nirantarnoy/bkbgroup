<?php
include("common/dbcon.php");
$id = '';
$bank_account = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['bank_account'])) {
    $bank_account = $_POST['bank_account'];
}

if ($bank_account != '') {
    $query = "SELECT * FROM member WHERE bank_account='$bank_account' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    echo $filtered_rows;

}else{
    echo 0;
}


?>
