<?php
ob_start();
session_start();

include("common/dbcon.php");

if(isset($_SESSION['userid'])){
    unset($_SESSION['userid']);
}
if(isset($_SESSION['branch'])){
    unset($_SESSION['branch']);
}

header("location: loginpage.php");

?>