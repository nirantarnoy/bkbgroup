<?php
//$HOST_NAME = "163.44.198.51";
//$DB_NAME = "cp628552_bkb";
//$CHAR_SET = "charset=utf8";
//$USERNAME = "cp628552_root";

//$PASSWORD = "58130_58130";


$HOST_NAME = "localhost";
$DB_NAME = "acc_member";
$CHAR_SET = "charset=utf8";
$USERNAME = "root";
$PASSWORD = "";

$connect = null;

try {
    $connect = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);
    //session_start();
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>
