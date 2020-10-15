<?php

session_start();
include "header.php";
if (empty($_SESSION['userid'])) {
    header('location:loginpage.php');
}

include 'common/dbcon.php';



$uid = 0;

if (!empty($_GET['user_id'])) {
    $uid = $_GET['user_id'];
}

$has_err = '';

if (!empty($_SESSION['msgerr'])) {
    $has_err = $has_err;
   // echo $has_err;return;
    unset($_SESSION['msgerr']);
}


?>

<div class="container" style="margin-top: 20px">
    <input type="hidden" id="has-err" value="<?=$has_err?>">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger has-err" style="display: none"><?=$has_err ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h2>เปลี่ยนรหัสผ่าน</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="changepassword.php" id="form-change" method="post">
                <table class="table">
                    <tr>
                        <td>รหัสผ่านเก่า</td>
                        <td><input name="old_pwd" type="password" class="form-control old-pwd" value=""></td>
                    </tr>
                    <tr>
                        <td>รหัสผ่านใหม่</td>
                        <td><input name="new_pwd" type="password" class="form-control new-pwd" value=""></td>
                    </tr>
                    <tr>
                        <td>ยืนยันรหัสผ่านใหม่</td>
                        <td><input name="confirm_pwd" type="password" class="form-control confirm-pwd" value=""></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" name="user_id" value="<?= $uid ?>">
                            <input type="submit" class="btn btn-outline-success btn-save" value="ตกลง">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</div>
<?php
include "footer.php";
?>
<script>
    $(function () {
        if($("#has-err").val()!=''){
            $(".has-err").show();
        }
        else{
            $(".has-err").hide();
        }

        $(".btn-save").click(function (e) {
            e.preventDefault();
            var old_pwd = $(".old-pwd").val();
            var new_pwd = $(".new-pwd").val();
            var confirm_pwd = $(".confirm-pwd").val();

            if(old_pwd == ''){
                $(".has-err").html("กรุณาป้อนรหัสผ่านเดิมก่อน");
                $(".has-err").show();
                $(".old-pwd").focus();
                return false;
            }
            if(new_pwd == ''){
                $(".has-err").html("กรุณาป้อนรหัสผ่านใหม่");
                $(".has-err").show();
                $(".new-pwd").focus();
                return false;
            }
            if(confirm_pwd == ''){
                $(".has-err").html("กรุณาป้อนรหัสยืนยัน");
                $(".has-err").show();
                $(".confirm-pwd").focus();
                return false;
            }
            if(new_pwd != confirm_pwd){
                $(".has-err").html("กรุณาป้อนรหัสผ่านใหม่และรหัสยืนยันให้ตรงกัน");
                $(".has-err").show();
                $(".confirm-pwd").focus();
                return false;
            }
            $("form#form-change").submit();
        });

    });

</script>
