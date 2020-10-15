<?php
ob_start();
session_start();
include("common/dbcon.php");

$name = '';
$description = '';
$recid = 0;


if (isset($_POST['bank_name'])) {
    $name = $_POST['bank_name'];
}
if (isset($_POST['description'])) {
    $description = $_POST['description'];
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}


if ($recid <= 0) {
    if ($name != '') {
        $sql = "INSERT INTO bank (name,description)
           VALUES ('$name','$description')";

        if ($result = $connect->query($sql)) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:bank.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:bank.php');
        }
    }

} else {
    $sql = "UPDATE bank SET name='$name',description='$description'";
    $sql.=" WHERE id='$recid'";

    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:bank.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:bank.php');
    }
}

?>
