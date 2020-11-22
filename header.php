<?php
ob_start();
date_default_timezone_set('Asia/Yangon');
//session_start();

if (!isset($_SESSION['userid'])) {
     header("location:loginpage.php");
}
include("common/dbcon.php");
include("models/UserModel.php");
include("models/PositionModel.php");

$user = '';
$user_position = 0;
$displayname = '';


if (isset($_SESSION['userid'])) {
    $user = $_SESSION['userid'];
}

if ($user) {
    $displayname = getDisplayname($user, $connect);
    $user_position = getUserposition($user,$connect);
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

    <title>bkb group</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap-toasts/css/toast.css">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


    <link href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <link rel="stylesheet" href="js/jquery-ui-1.12.1.custom/jquery-ui-1.12.1.custom/jquery-ui.css">



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

        input[type=checkbox] {
            /* Double-sized Checkboxes */
            -ms-transform: scale(0.5); /* IE */
            -moz-transform: scale(0.5); /* FF */
            -webkit-transform: scale(0.5); /* Safari and Chrome */
            -o-transform: scale(0.5); /* Opera */
            padding: 1px;
        }

        /*td.nowrap {*/
        /*white-space: nowrap;*/
        /*}*/
        table {
            /*table-layout: fixed !important;*/
            word-wrap: break-word;
        }

        /*::placeholder { !* Chrome, Firefox, Opera, Safari 10.1+ *!*/
            /*color: red;*/
            /*opacity: 1; !* Firefox *!*/
        /*}*/

    </style>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
<!--    bg-gradient-primary-->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="member.php">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-tags"></i>
            </div>
            <div class="sidebar-brand-text mx-3">BKB GROUP</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Menu
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <!--        <li class="nav-item">-->
        <!--            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">-->
        <!--                <i class="fas fa-fw fa-cog"></i>-->
        <!--                <span>Components</span>-->
        <!--            </a>-->
        <!--            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">-->
        <!--                <div class="bg-white py-2 collapse-inner rounded">-->
        <!--                    <h6 class="collapse-header">Custom Components:</h6>-->
        <!--                    <a class="collapse-item" href="buttons.html">Buttons</a>-->
        <!--                    <a class="collapse-item" href="cards.html">Cards</a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </li>-->
        <!---->
        <!--        <!-- Nav Item - Utilities Collapse Menu -->
        <!--        <li class="nav-item">-->
        <!--            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">-->
        <!--                <i class="fas fa-fw fa-wrench"></i>-->
        <!--                <span>Utilities</span>-->
        <!--            </a>-->
        <!--            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">-->
        <!--                <div class="bg-white py-2 collapse-inner rounded">-->
        <!--                    <h6 class="collapse-header">Custom Utilities:</h6>-->
        <!--                    <a class="collapse-item" href="utilities-color.html">Colors</a>-->
        <!--                    <a class="collapse-item" href="utilities-border.html">Borders</a>-->
        <!--                    <a class="collapse-item" href="utilities-animation.html">Animations</a>-->
        <!--                    <a class="collapse-item" href="utilities-other.html">Other</a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </li>-->
        <!---->
        <!--        <!-- Divider -->
        <!--        <hr class="sidebar-divider">-->
        <!---->
        <!--        <!-- Heading -->
        <!--        <div class="sidebar-heg">-->
        <!--            Addons-->
        <!--        </div>-->
        <!---->
        <!--        <!-- Nav Item - Pages Collapse Menu -->
        <!--        <li class="nav-item">-->
        <!--            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">-->
        <!--                <i class="fas fa-fw fa-folder"></i>-->
        <!--                <span>Pages</span>-->
        <!--            </a>-->
        <!--            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">-->
        <!--                <div class="bg-white py-2 collapse-inner rounded">-->
        <!--                    <h6 class="collapse-header">Login Screens:</h6>-->
        <!--                    <a class="collapse-item" href="login.html">Login</a>-->
        <!--                    <a class="collapse-item" href="register.html">Register</a>-->
        <!--                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>-->
        <!--                    <div class="collapse-divider"></div>-->
        <!--                    <h6 class="collapse-header">Other Pages:</h6>-->
        <!--                    <a class="collapse-item" href="404.html">404 Page</a>-->
        <!--                    <a class="collapse-item" href="blank.html">Blank Page</a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </li>-->

        <!-- Nav Item - Charts -->
        <?php if (checkPer($user_position,"is_company_account", $connect)): ?>
        <li class="nav-item">
            <a class="nav-link" href="bank_company.php">
                <i class="fas fa-fw fa-list-alt" style="font-size: 18px;"></i>
                <span class="menu-text" style="font-size: 20px;">My Bank</span></a>
        </li>
        <?php endif;?>
        <?php if (checkPer($user_position,"is_statistics", $connect)): ?>
            <li class="nav-item">
                <a class="nav-link" href="statistics.php">
                    <i class="fas fa-fw fa-chart-line" style="font-size: 18px;"></i>
                    <span class="menu-text" style="font-size: 20px;">Statistics</span></a>
            </li>
        <?php endif;?>
        <?php if (checkPer($user_position,"is_member", $connect)): ?>
            <li class="nav-item">
                <a class="nav-link" href="member.php">
                    <i class="fas fa-fw fa-user" style="font-size: 18px;"></i>
                    <span class="menu-text" style="font-size: 20px;">Members</span></a>
            </li>
        <?php endif;?>
        <?php if (checkPer($user_position,"is_member", $connect)): ?>
            <li class="nav-item">
                <a class="nav-link" href="skmmember.php">
                    <i class="fas fa-fw fa-user" style="font-size: 18px;"></i>
                    <span class="menu-text" style="font-size: 20px;">SKM Members</span></a>
            </li>
        <?php endif;?>
        <?php if (checkPer($user_position,"is_accounting", $connect)): ?>
        <li class="nav-item">
            <a class="nav-link" href="memberaccounting.php">
                <i class="fas fa-fw fa-edit" style="font-size: 20px;"></i>
                <span style="font-size: 20px;">Accounting</span></a>
        </li>
        <?php endif;?>
        <?php if (checkPer($user_position,"is_capital", $connect)): ?>
        <li class="nav-item">
            <a class="nav-link" href="capital.php">
                <i class="fas fa-fw fa-money-check" style="font-size: 20px;"></i>
                <span style="font-size: 20px;">Capital</span></a>
        </li>
        <?php endif;?>
        <?php if (checkPer($user_position,"is_promotion", $connect)): ?>
        <li class="nav-item">
            <a class="nav-link" href="promotion.php">
                <i class="fas fa-fw fa-list" style="font-size: 18px;"></i>
                <span style="font-size: 18px;">Promotion Setting</span></a>
        </li>
        <?php endif;?>
        <?php if (checkPer($user_position,"is_user", $connect)): ?>
        <li class="nav-item">
            <a class="nav-link" href="bank.php">
                <i class="fas fa-fw fa-building" style="font-size: 18px;"></i>
                <span style="font-size: 18px;">Bank Setting</span></a>
        </li>
        <?php endif;?>
        <?php if (checkPer($user_position,"is_position", $connect) && checkPer($user_position,"is_all", $connect)): ?>
            <li class="nav-item">
                <a class="nav-link" href="position.php">
                    <i class="fas fa-fw fa-check-circle" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">Position</span></a>
            </li>
        <?php endif; ?>
        <?php if (checkPer($user_position,"is_user", $connect)): ?>
            <li class="nav-item">
                <a class="nav-link" href="user.php">
                    <i class="fas fa-fw fa-users" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">Users</span></a>
            </li>
        <?php endif; ?>


        <!--        <li class="nav-item">-->
        <!--            <a class="nav-link" href="report.php">-->
        <!--                <i class="fas fa-fw fa-chart-pie"></i>-->
        <!--                <span>รายงาน</span></a>-->
        <!--        </li>-->
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
<!--                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">-->
<!--                    <div class="input-group">-->
<!--                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."-->
<!--                               aria-label="Search" aria-describedby="basic-addon2">-->
<!--                        <div class="input-group-append">-->
<!--                            <button class="btn btn-primary" type="button">-->
<!--                                <i class="fas fa-search fa-sm"></i>-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </form>-->

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $displayname ?></span>
                            <img class="img-profile rounded-circle" src="img/profile.png">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <!--                            <a class="dropdown-item" href="changepwdpage.php?user_id=-->
                            <? //=$user?><!--">-->
                            <!--                                <i class="fas fa-check fa-sm fa-fw mr-2 text-gray-400"></i>-->
                            <!--                                000001-->
                            <!--                            </a>-->

                            <a class="dropdown-item" href="changepwdpage.php?user_id=<?= $user ?>">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Change password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">




