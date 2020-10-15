<?php
include("common/dbcon.php");
$id = '';
$phone = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['phone'])) {
    $phone = trim($_POST['phone']);
}

if ($phone != '') {
    $query = "SELECT * FROM member WHERE phone='$phone' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    echo $filtered_rows;

}else{
    echo 0;
}


?>
