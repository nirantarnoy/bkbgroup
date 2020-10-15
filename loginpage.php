<?php
 session_start();

 $mes_error = '';
 if(isset($_SESSION['msg_err'])){
     $mes_error = $_SESSION['msg_err'];
     unset($_SESSION['msg_err']);
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BKB group | Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Kanit-Regular';
            src: url('fonts/kanit/Kanit-Regular.ttf') format('truetype');
            /* src: url('../fonts/thsarabunnew-webfont.eot?#iefix') format('embedded-opentype'),
                  url('../fonts/thsarabunnew-webfont.woff') format('woff'),
                  url('../fonts/EkkamaiStandard-Light.ttf') format('truetype');*/
            font-weight: normal;
            font-style: normal;
        }

        html, body {
            height: 100%;
            font-family: 'Kanit-Regular';
            padding: 0px;
            margin: 0px;
            /*position: relative;*/
            /*display:flex;*/
            /*min-height: 100%;*/
            width: 100%;
        }

        body {
            overflow-x: hidden;
        }
    </style>
</head>

<body class="bg-gradient-primary">

<div class="container">
    <br>
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">
            <br>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4" style="background: white">
                    <br>
                    <div class="text-center">
                        <h1>BKB</h1>
<!--                        <h1>MASTERY EXPRESS</h1>-->
                        <h1 class="h6 text-gray-900 mb-4">Please Login</h1>
                    </div>
                    <br>
                    <input type="hidden" class="message" value="<?=$mes_error?>">
                    <div class="alert alert-danger alert-msg" style="display: none"><?=$mes_error?></div>
                    <form class="user" action="login_action.php" id="form-login" method="post">
                        <!-- <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                   aria-describedby="emailHelp" placeholder="Enter Email Address...">
                        </div> -->
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user username" id="exampleInputEmail"
                                   aria-describedby="emailHelp" name="username" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control form-control-user password" id="exampleInputPassword"
                                   placeholder="Password">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" name="remember" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary btn-user btn-block btn-submit" value="Login">

                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                    </div>
                    <br>
                </div>
                <div class="col-lg-4"></div>
            </div>

        </div>

    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>


<script>
  $(function(){
     err_message();
      $(".btn-submit").click(function(e){
          e.preventDefault();
          var username = $(".username").val();
          var pwd = $(".password").val();

          if(username == ''){
             $(".message").val("กรุณากรอกข้อมูล Username");
             $(".username").focus();
             err_message();
             return false;
          }
          if(pwd == ''){
             $(".message").val("กรุณากรอกข้อมูล Password");
             $(".password").focus();
             err_message();
             return false;
          }
          $("form#form-login").submit();
      });

      function err_message(){
          var e_msg = $(".message").val();
        if(e_msg !=''){
          $(".alert-msg").html(e_msg).show();
      }else{
          $(".alert-msg").hide();
      }

      }
  });
</script>

</body>

</html>

