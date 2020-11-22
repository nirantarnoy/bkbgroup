<?php
ob_start();

session_cache_expire(1440);
$cache_expire = session_cache_expire();

session_start();
date_default_timezone_set('Asia/Yangon');
include("common/dbcon.php");
include("models/PositionModel.php");

$username = '';
$password = '';

if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}

//echo md5($password);return;

if ($username != '' && $password != '') {
    $newpass = md5($password);
    $query = "SELECT * FROM user WHERE username='$username' AND password='$newpass'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        $user_position = 0;
        foreach ($result as $row) {
            $_SESSION['userid'] = $row['id'];
            $user_position = $row['position_id'];
            if (!empty($_POST["remember"])) {
                setcookie("member_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
            } else {
                if (isset($_COOKIE["member_login"])) {
                    setcookie("member_login", "");
                }
            }
        }
        // if(checktime($_SESSION['userid'] , $connect)){
        $init_page = checkInitper($user_position, $connect);
        //echo $init_page;return;
        if($init_page != ''){
            header('location: '.$init_page.'.php');
        }else{
            header('location: loginpage.php');
        }
        // }else{

        //    header("location:loginpage.php");
        //}
    } else {
        $_SESSION['msg_err'] = 'Usernam Or Password incorrect';
        header("location:loginpage.php");
    }

}

function checktime($uid, $connect)
{

    $query = "SELECT * FROM user WHERE id='$uid'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $c_time = date('H:i');
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $start = $row['use_start'];
            $end = $row['use_end'];

            if (($c_time >= $start) && ($c_time <= $end)) {
                return true;
            } else {
                return false;
            }

        }
    } else {
        return false;
    }
}

?>
