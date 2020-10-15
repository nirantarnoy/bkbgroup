<?php
include("common/dbcon.php");

$name = '';

if (isset($_POST['account_id'])) {
    $name = trim($_POST['account_id']);
}

if ($name != '') {
    $query = "SELECT * FROM member WHERE account_id='$name' ";
    $statement = $connect->prepare($query);
    $statement->execute();
   // $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    echo $filtered_rows;

}else{
    echo 0;
}


?>
