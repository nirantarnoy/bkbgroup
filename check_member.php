<?php
include("common/dbcon.php");

$name = '';

if (isset($_POST['name'])) {
    $name = trim($_POST['name']);
}

if ($name != '') {
    $query = "SELECT * FROM member WHERE name='$name' ";
    $statement = $connect->prepare($query);
    $statement->execute();
   // $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    echo $filtered_rows;

}else{
    echo 0;
}


?>
