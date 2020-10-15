<?php
ob_start();
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
?>
