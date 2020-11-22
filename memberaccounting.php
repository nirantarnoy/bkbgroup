<?php
ob_start();
session_start();
//date_default_timezone_set('Asia/Bangkok');
if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
//echo date('H:i');return;
include "header.php";
include("models/BankModel.php");
include("models/PromotionModel.php");
include("models/BankCompanyModel.php");
//include("models/PositionModel.php");


$position_data = getPositionmodel($connect);
$per_check = checkPer($user_position, "is_accounting", $connect);
if (!$per_check) {
    header("location:errorpage.php");
}


$bank_data =getBankmodel($connect);
$bank_com_data = getBankAccountmodel($connect);
$promotion_data = getPromotionmodel($connect);
$noti_ok = '';
$noti_error = '';


$c_date = date('d/m/Y');

if (!empty($_SESSION['msg-success'])) {
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if (isset($_SESSION['msg-error'])) {
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}
$member_group_data = [['id'=>1,'name'=>'MEMBER'],['id'=>2,'name'=>'SKM']];
?>
<input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
<input type="hidden" class="msg-error" value="<?= $noti_error ?>">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Accounting</h1>
    <div class="btn-group">
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
           onclick="showreport($(this))"><i class="fas fa-print fa-sm text-white-50"></i> Total Reports</a>
        <!--                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm btn-main-export"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_member.php" id="form-delete" method="post" enctype="multipart/form-data">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <div class="row">
            <div class="col-lg-12">
                <div class="input-group">
                    <select name="member_group_id" id="member-group-id-search" class="form-control member-group-id-search"
                            style="margin-left: 5px;">
                        <option value="0">--Select Group--</option>
                        <?php for ($i = 0; $i <= count($member_group_data) - 1; $i++): ?>
                            <option value="<?= $member_group_data[$i]['id'] ?>"><?= $member_group_data[$i]['name'] ?></option>
                        <?php endfor; ?>
                    </select>
                    <input type="text" class="form-control search-text" id="search-text" name="search_text"
                           placeholder="Search">
                    <!--                    <button class="btn btn-primary">Search</button>-->
                    <!--                    <input type="text" class="form-control search-index" id="search-index" name="search_index" placeholder="index">-->
                    <!--                    <input type="text" class="form-control search-plate" id="search-prod" name="search_prod" placeholder="สินค้า">-->
                </div>
            </div>
        </div>
        <br />
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Active Date</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Bank Name</th>
                    <th>Bank Account</th>
                    <th>ID_Number</th>
                    <th style="text-align: right">Cash In</th>
                    <th style="text-align: right">Cash Out</th>
                    <th style="text-align: right">Net Win</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="#" id="form-user" method="post">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">Add New Member</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <h4><label for="">Search History</label></h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-inline">
                                <input type="text" class="form-control trans-from-date-search" value="">
                                <input type="text" class="form-control trans-to-date-search" value=""
                                       style="margin-left: 5px;">
                                <select name="find_promotion" id="find-promotion-search"
                                        class="form-control find-promotion"
                                        style="margin-left: 5px;">
                                    <option value="0">--Select Promotion--</option>
                                    <?php for ($i = 0; $i <= count($promotion_data) - 1; $i++): ?>
                                        <option value="<?= $promotion_data[$i]['id'] ?>"><?= $promotion_data[$i]['name'] ?></option>
                                    <?php endfor; ?>
                                </select>
                                <div class="btn btn-info btn-group btn-search-data" style="margin-left: 5px;">
                                    Search
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="">Account ID</label>
                                    <input type="text" class="form-control account-id" name="account_id" value=""
                                           placeholder="Account ID" readonly>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control member-name" name="member_name" value=""
                                           placeholder="Name" readonly>
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="">Date of birth</label>
                                    <input type="text" class="form-control member-dob" name="member_dob" value=""
                                           placeholder="Date of birth" readonly>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Phone</label>
                                    <input type="text" class="form-control phone" name="phone" value=""
                                           placeholder="Phone" readonly>
                                </div>

                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="">Bank Name</label>
                                    <select name="bank_id" id="bank-id" class="form-control bank-id" readonly>
                                        <?php for ($i = 0; $i <= count($bank_data) - 1; $i++): ?>
                                            <option value="<?= $bank_data[$i]['id'] ?>"><?= $bank_data[$i]['name'] ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Bank Account</label>
                                    <input type="text" class="form-control bank-account" name="bank_account" value=""
                                           placeholder="Back account" readonly>
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="">ID Number</label>
                                    <input type="text" class="form-control id-number" name="id_number" value=""
                                           placeholder="ID Number" readonly>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">LV2</label>
                                    <select name="is_level2" id="" class="form-control is-level2" readonly>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4" style="border-left: 1px solid gray;">
                            <h4><label for="">Record Transaction</label></h4>
                            <input type="hidden" class="select-member-id" name="member_id" value="">
                            <input type="hidden" class="action-type" value="" name="action_type">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="">Deposit</label>
                                    <input type="text" class="form-control deposit" name="deposit" value="0"
                                           placeholder="Deposit" onchange="cashcal($(this))">
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="">Withdraw</label>
                                    <input type="text" class="form-control withdraw" name="withdraw" value="0"
                                           placeholder="Withdraw" onchange="cashcal($(this))">
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-lg-8">
                                    <label for="">Bank Name</label>
                                    <select name="bank_com_id" id="" class="form-control bank-com-id" required>
                                        <option value="0">--Select Bank name--</option>
                                        <?php for ($i = 0; $i <= count($bank_com_data) - 1; $i++): ?>
                                            <option value="<?= $bank_com_data[$i]['id'] ?>"><?= $bank_com_data[$i]['name'] ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="" style="color: white">Balance</label>
                                    <div class="btn btn-primary btn-balance-show">Balance</div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="">Promotion</label>
                                    <select name="promotion_id" id="promotion-id" class="form-control promotion-id"
                                            style="margin-left: 5px;" onmouseover="showtooltip($(this))"
                                            title="Please select promotion">
                                        <option value="0">--Select Promotion--</option>
                                        <?php for ($i = 0; $i <= count($promotion_data) - 1; $i++): ?>
                                            <option value="<?= $promotion_data[$i]['id'] ?>"><?= $promotion_data[$i]['name'] ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="">Turn Over</label>
                                    <input type="text" class="form-control turnover" name="turnover" value="0"
                                           placeholder="Turn over">
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="btn btn-success btn-record-save">Save</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-lg-4">
                            <h5><a href="#" onclick="show_deposit_history($(this))">Cash In: </a><span class=""><input
                                            type="text" class="form-control text-cash-in"
                                            readonly value="0"></span></h5>
                        </div>
                        <div class="col-lg-4">
                            <h5><a href="#" onclick="show_withdraw_history($(this))">Cash Out: </a><span class=""><input
                                            type="text"
                                            class="form-control text-cash-out" readonly
                                            value="0"></span></h5>
                        </div>
                        <div class="col-lg-4">
                            <h5>Net Win: <span class=""><input type="text" class="form-control text-net-win"
                                                               readonly value="0"></span></h5>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-4">
                            <h5 class="text-primary"><a href="#" onclick="show_pro_history($(this))">Promotion:</a>
                                <span class=""><input type="text"
                                                      class="form-control text-promotion-name"
                                                      readonly value=""></span></h5>
                        </div>
                        <div class="col-lg-4">
                            <h5>Last Time: <span class="text-danger"><input type="text"
                                                                            class="form-control text-last-promotion"
                                                                            readonly value=""></span></h5>
                        </div>
                        <div class="col-lg-4">
                            <h5>Get: <span class="text-danger"><input type="text"
                                                                      class="form-control text-get-promotion"
                                                                      readonly value="0"></span></h5>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-4">
                            <h5 class="text-primary"><a href="#" onclick="show_turnover_history($(this))">Turn Over:</a>
                                <span class=""><input type="text"
                                                      class="form-control text-turnover-amount"
                                                      readonly value="0"></span></h5>
                        </div>
                        <div class="col-lg-4">
                            <h5>Last Time: <span class="text-danger"><input type="text"
                                                                            class="form-control text-last-turnover"
                                                                            readonly value=""></span></h5>
                        </div>
                        <div class="col-lg-4">
                            <h5>Get: <span class="text-danger"><input type="text"
                                                                      class="form-control text-get-turnover"
                                                                      readonly value="0"></span></h5>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <!--                    <input type="submit" class="btn btn-success btn-save" data-dismiss="modalx" value="บันทึก">-->
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="reportModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-" style="color: #1c606a">Total Reports</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-inline">
                            <input type="text" class="form-control report-from-date" value="" placeholder="From Date">
                            <input type="text" class="form-control report-to-date" value="" style="margin-left: 5px;"
                                   placeholder="To Date">
                            <select name="member_group_id" id="member-group-id" class="form-control member-group-id"
                                    style="margin-left: 5px;">
                                <option value="0">--Select Group--</option>
                                <?php for ($i = 0; $i <= count($member_group_data) - 1; $i++): ?>
                                    <option value="<?= $member_group_data[$i]['id'] ?>"><?= $member_group_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                            <select name="" id="report-find-promotion" class="form-control report-find-promotion"
                                    style="margin-left: 5px;">
                                <option value="0">--Select Promotion--</option>
                                <?php for ($i = 0; $i <= count($promotion_data) - 1; $i++): ?>
                                    <option value="<?= $promotion_data[$i]['id'] ?>"><?= $promotion_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="btn btn-info btn-group btn-find-report" style="margin-left: 5px;">Search</div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped table-report">
                            <thead>
                            <tr>
                                <th>Active Date</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Bank</th>
                                <th>BankAccount</th>
                                <th>ID_Number</th>
                                <th style="text-align: right">Cash In</th>
                                <th style="text-align: right">Cash Out</th>
                                <th style="text-align: right">Net Win</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-export"><i class="fa fa-download"></i> Export</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="promotionHistoryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-" style="color: #1c606a">Promotion history</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped table-promotion-history">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Promotion list</th>
                                <th style="text-align: center">-</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-primary btn-export"><i class="fa fa-download"></i> Export</button>-->
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="turnoverHistoryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-" style="color: #1c606a">Turn Over history</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped table-turnover-history">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th style="text-align: center">-</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-primary btn-export"><i class="fa fa-download"></i> Export</button>-->
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="depositHistoryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-" style="color: #1c606a">Deposit history</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped table-deposit-history">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th style="text-align: center">-</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-primary btn-export"><i class="fa fa-download"></i> Export</button>-->
                <!--                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>-->
                <button type="button" class="btn btn-danger btn-close-deposit-modal"
                        onclick="$('#depositHistoryModal').modal('hide')"><i class="fa fa-ban"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="withdrawHistoryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-" style="color: #1c606a">Withdraw history</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped table-withdraw-history">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th style="text-align: center">-</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-primary btn-export"><i class="fa fa-download"></i> Export</button>-->
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="bankbalanceModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-" style="color: #1c606a">Account Balance</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped table-balance">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Account number</th>
                                <th>Bank Name</th>
                                <th>Balance</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-primary btn-export"><i class="fa fa-download"></i> Export</button>-->
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<form action="export_member_report.php" method="post" id="form-export-total">
    <input type="hidden" name="promotion_id" value="" class="form-promotion">
    <input type="hidden" name="from_date" value="" class="form-from-date">
    <input type="hidden" name="to_date" value="" class="form-to-date">
</form>
<?php
include "footer.php";
?>

<script>
    notify();

    $(document).tooltip();

    $(".withdraw,.deposit,.turnover").on("keypress",function(event){
        $(this).val($(this).val().replace(/[^0-9\.]/g,""));
        if((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which <48 || event.which >57)){event.preventDefault();}
    });

    $(".report-from-date,.report-to-date").datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $(".trans-from-date-search").datepicker({
        dateFormat: 'dd/mm/yy',
        todayHighlight: true,
        autoclose: true
    });
    $(".trans-to-date-search").datepicker({
        dateFormat: 'dd/mm/yy',
        todayHighlight: true,
        autoclose: true
    });
    // $(".report-from-date").datepicker({
    //     dateFormat: 'dd/mm/yy',
    //     todayHighlight: true,
    //     autoclose: true
    // });
    // $(".report-to-date").datepicker({
    //     dateFormat: 'dd/mm/yy',
    //     todayHighlight: true,
    //     autoclose: true
    // });

    $(".report-to-date").on("change", function () {
        var s_date = $(".report-from-date").val();
        if ($(this).val() < s_date) {
            $(this).val(s_date);
        }
    });

    $(".btn-export").click(function () {
        var promotion = $(".report-find-promotion").val();
        var f_date = $(".report-from-date").val();
        var t_date = $(".report-to-date").val();

        $(".form-from-date").val(f_date);
        $(".form-to-date").val(t_date);
        $(".form-promotion").val(promotion);
        $("form#form-export-total").submit();
    });

    $(".btn-main-export").click(function () {
        var promotion = $(".report-find-promotion").val();
        var f_date = $("#search-from-date").val();
        var t_date = $("#search-to-date").val();

        $(".form-from-date").val(f_date);
        $(".form-to-date").val(t_date);
        $(".form-promotion").val(promotion);
        $("form#form-export-total").submit();
    });

    $(".btn-find-report").click(function () {
        var promotion = $(".report-find-promotion").val();
        var member_type = $(".member-group-id").val();
        var f_date = $(".report-from-date").val();
        var t_date = $(".report-to-date").val();
//alert(member_type);
        if (promotion != null) {
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'get_account_report.php',
                'data': {'promotion_id': promotion, 'from_date': f_date, 'to_date': t_date,'member_group_id': member_type},
                'success': function (data) {
                    if (data != '') {
                        $(".table-report tbody").html(data);
                    } else {
                        alert("err");
                    }
                }
            });
        }
    });

    $(".btn-balance-show").click(function(){
        var bank_id = $(".bank-com-id").val();
        if(bank_id > 0){
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'balance_fetch.php',
                'data': {'id': bank_id},
                'success': function (data) {
                      $(".table-balance tbody").html(data);
                      $("#bankbalanceModal").modal("show");
                }
            });
        }

    });

    $(".btn-search-data").click(function () {
        var member_id = $(".select-member-id").val();
        var promotion = $(".find-promotion").val();
        var from_date = $(".trans-from-date-search").val();
        var to_date = $(".trans-to-date-search").val();
        var promotion_name = '';
        if (promotion > 0) {
            promotion_name = $(".find-promotion option:selected").text();
        }

        // var withdraw = $(".withdraw").val();

        if (member_id > 0) {
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_member_account_trans.php',
                'data': {'member_id': member_id, 'promotion_id': promotion, 'from_date': from_date, 'to_date': to_date},
                'success': function (data) {
                    if (data.length > 0) {
                        //  alert(data[0]['last_turnover_date']);
                        $(".text-promotion-name").val(data[0]['last_promotion_name']);
                        if (data[0]['last_promotion_name'] == '') {
                            $(".text-promotion-name").val(promotion_name);
                        }

                        $(".text-last-promotion").val(data[0]['last_promotion']);
                        $(".text-turnover-amount").val(addCommas(data[0]['last_turnover']));
                        // $(".text-last-turnover").val(data[0]['last_turnover_date']);
                        $(".text-get-promotion").val(data[0]['promotion_cnt']);
                        // $(".text-get-turnover").val(data[0]['turnover_cnt']);
                        // $(".text-cash-in").val(addCommas(data[0]['cash_in']));
                        // $(".text-cash-out").val(addCommas(data[0]['cash_out']));
                        //
                        // $(".text-net-win").val(addCommas(data[0]['net_win']));
                        if (data[0]['net_win'] < 0) {
                            $(".text-net-win").addClass("text-danger");
                        } else {
                            $(".text-net-win").removeClass("text-danger");
                        }

                    } else {
                        alert("err");
                    }
                }
            });
        }
    });

    $(".btn-record-save").click(function () {
        var member_id = $(".select-member-id").val();
        var deposit = $(".deposit").val();
        var withdraw = $(".withdraw").val();
        var promotion = $(".promotion-id").val();
        var turnover = $(".turnover").val();
        var action_type = $(".action-type").val();
        var bank_id = $(".bank-com-id").val();

        if(deposit > 0 || withdraw >0){
            if(bank_id == 0){
                alert("Please select bank before.");
                $(".bank-com-id").focus();
                return;
            }
        }

        if (member_id > 0) {
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'add_member_account.php',
                'data': {
                    'member_id': member_id,
                    'deposit': deposit,
                    'withdraw': withdraw,
                    'promotion_id': promotion,
                    'turnover': turnover,
                    'action_type': action_type,
                    'bank_id': bank_id
                },
                'success': function (data) {
                    if (data == 1) {
                        custom_noti('success', 'Save data successfully');
                        $(".find-promotion").val(0).change();
                        $(".deposit").val(0);
                        $(".withdraw").val(0);
                        $(".turnover").val(0);
                        $(".bank-id").val(0).change();
                        //$(".btn-search-data").trigger('click');
                        get_last_promotion(member_id);
                        get_last_turnover(member_id);
                        get_last_cash(member_id);
                    } else {
                        custom_noti('error', 'Save data error');
                    }
                }
            });
        }


    });

    function custom_noti(status, message) {
        $.toast({
            title: 'Message notify',
            subtitle: '',
            content: message,
            type: status,
            delay: 3000,
            pause_on_hover: false
        });
    }

    $(".promotion-id").change(function () {
        if ($(this).val() > 0) {
            $(".text-promotion-name").val($(".promotion-id option:selected").text());
        } else {
            $(".text-promotion-name").val('');
        }

    });

    $(".turnover").change(function () {
        $(".text-turnover-amount").val($(this).val());
    });

    function cashcal(e) {
        var new_in_amt = $('.deposit').val();
        var new_out_amt = $('.withdraw').val();
        var id = $(".user-recid").val();
        if (id) {
            // alert(id);
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_member_account_cash.php',
                'data': {'id': id},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(data[0]['deposit']);
                        new_in_amt = parseFloat(new_in_amt) + parseFloat(data[0]['deposit']);
                        new_out_amt = parseFloat(new_out_amt) + parseFloat(data[0]['withdraw']);
                        $(".text-cash-in").val(addCommas(new_in_amt));
                        $(".text-cash-out").val(addCommas(new_out_amt));
                        $(".text-net-win").val(addCommas(new_in_amt - new_out_amt));
                    }
                }
            });
        }
    }

    function deleteTrans(e, trans_type){
        var recid = e.attr('data-id');
        var curren_id = $(".select-member-id").val();
        if(curren_id && recid){
            if(confirm('Are you sure to delete?')){
                $.ajax({
                    'type': 'post',
                    'dataType': 'html',
                    'async': false,
                    'url': 'delete_trans.php',
                    'data': {'recid': recid},
                    'success': function (data) {
                        if (data > 0) {
                          if(trans_type == 1){
                              show_deposit_history(e);
                          }
                            if(trans_type == 2){
                                show_withdraw_history(e);
                            }
                            if(trans_type == 3){
                                show_pro_history(e);
                            }
                            if(trans_type == 4){
                                show_turnover_history(e);
                            }
                          get_last_cash(curren_id);
                          get_last_turnover(curren_id);
                          get_last_promotion(curren_id);
                        }
                    }
                });
            }
        }
    }

    function showreport(e) {
        $("#reportModal").modal("show");
    }

    function showaddmember(e) {
        $(".user-recid").val();
        $(".bank-name").val('');
        $(".description").val('');
        $("#myModal").modal("show");
    }

    $("#dataTable").append('<tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th style="text-align: right"></th><th></th><th></th><th></th></tfoot>');
    var dataTablex = $("#dataTable").DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[1, "desc"]],
        "pageLength": 10,
        "filter": false,
        //"order": [],
        //"aaSorting": [[ 8, "desc" ]],
        "ajax": {
            url: "member_account_fetch.php",
            type: "POST",
                    data: function (data) {
                        // Read values
                        var search_text = $('#search-text').val();
                        var member_type = $('#member-group-id-search').val();
                        // var index = $('#search-index').val();
                        // // Append to data
                        data.searchByText = search_text;
                        data.searchByMemberType = member_type;
                        // data.searchByIndex = index;
                    }
        },
        // initComplete: function () {
        //     this.api().columns().every(function () {
        //         var column = this;
        //         var select = $('<select><option value=""></option></select>')
        //             .appendTo($(column.header()).empty())
        //             .on('change', function () {
        //                 var val = $.fn.dataTable.util.escapeRegex(
        //                     $(this).val()
        //                 );
        //             });
        //     });
        // },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },
            {
                type: 'date',
                targets: [ 1 ]
            },
            // {
            //     type: 'numeric-comma',
            //     targets:  [8]
            // },
            {
                targets: [8, 9, 10],
                className: 'text-right'
            },

        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            /* numbers less than or equal to 0 should be in red text */
            if (parseFloat(aData[10]) < 0) {
                jQuery('td:eq(10)', nRow).addClass('text-danger');
            }
            return nRow;
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;
            // converting to interger to find total
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            var total_in = api
                .column(8)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                    //return a + a;
                }, 0);
            var all_total_in = addCommas(parseFloat(total_in));
            var total_out = api
                .column(9)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                    //return a + a;
                }, 0);
            var all_total_out = addCommas(parseFloat(total_out));
            var total_net = api
                .column(10)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                    //return a + a;
                }, 0);
            var all_total_net = addCommas(parseFloat(total_net));
            // data = api.column(3, { page: 'current'} ).data();
            // pageTotal = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) : 0;

            // Update footer
            // var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '£' ).display;
            $(api.column(1).footer()).html('<p style="text-align: right">Total</p>');
            $(api.column(8).footer()).html(all_total_in);
            $(api.column(9).footer()).html(all_total_out);
            $(api.column(10).footer()).html(all_total_net);
        }

    });
    // var dataTablex = $("#dataTable").DataTable({
    //     "processing": true,
    //     "serverSide": true,
    //     "order": [[1, "asc"]],
    //     "pageLength": 100,
    //     "filter": false,
    //     "ajax": {
    //         url: "member_account_fetch.php",
    //         type: "POST",
    //         data: function (data) {
    //             // Read values
    //             var from_date = $('#search-from-date').val();
    //             var to_date = $('#search-to-date').val();
    //             var search_text = $('#search-text').val();
    //             var promotion = $('#find-promotion-search').val();
    //             // var index = $('#search-index').val();
    //             // // Append to data
    //             data.searchByFromdate = from_date;
    //             data.searchByTodate = to_date;
    //             data.searchByText = search_text;
    //             data.searchByPromotion = promotion;
    //             // data.searchByIndex = index;
    //         }
    //     },
    //     "columnDefs": [
    //         {
    //             "targets": [0],
    //             "orderable": false,
    //         },
    //
    //     ],
    //
    // });
    //
    $("#search-text").change(function(){
        dataTablex.draw();
    });
    // $("#search-from-date").change(function(){
    //     //alert($(this).val());
    //     dataTablex.draw();
    // });
    // $("#search-to-date").change(function(){
    //     dataTablex.draw();
    // });
    $("#member-group-id-search").change(function(){
        dataTablex.draw();
    });

    function showmanage(e) {
        var recid = e.attr("data-id");
        $(".find-promotion").val(0).change();
        $(".deposit").val(0);
        $(".withdraw").val(0);
        $(".turnover").val(0);
        $(".text-turnover-amount").val(0);
        $(".bank-com-id").val(0).change();

        $(".action-type").val("create");
        //  alert(recid);
        if (recid != '') {
            var account_id = '';
            var name = '';
            var dob = '';
            var phone = '';
            var id_number = '';
            var bank_id = -1;
            var bank_account = '';
            var is_level2 = 0;
            var turnover = 0;
            var turnover_last = '';
            var turnover_get = 0;
            var promotion_last_name = '';
            var promotion_last = '';
            var promotion_get = 0;
            var deposit = 0;
            var withdraw = 0;
            var net_win = 0;


            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_member_update.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(data[0]['display_name']);
                        account_id = data[0]['account_id'];
                        name = data[0]['name'];
                        dob = data[0]['dob'];
                        phone = data[0]['phone'];
                        id_number = data[0]['id_number'];
                        bank_id = data[0]['bank_id'];
                        bank_account = data[0]['bank_account'];
                        is_level2 = data[0]['is_level2'];
                        turnover = data[0]['turnover_amt'];
                        turnover_last = data[0]['turnover_date'];
                        turnover_get = data[0]['turnover_get'];
                        promotion_last = data[0]['promotion_date'];
                        promotion_get = data[0]['promotion_get'];
                        promotion_last_name = data[0]['promotion_name'];
                        deposit = data[0]['cash_in'];
                        withdraw = data[0]['cash_out'];
                        net_win = data[0]['net_win'];
                    }
                }
            });

            $(".user-recid").val(recid);
            $(".account-id").val(account_id);
            $(".member-name").val(name);
            $(".member-dob").val(dob);
            $(".phone").val(phone);
            $(".id-number").val(id_number);
            $(".bank-id").val(bank_id).change();
            $(".bank-account").val(bank_account);
            $(".is-level2").val(is_level2).change();
            $(".text-turnover-amount").val(turnover);
            $(".text-last-turnover").val(turnover_last);
            $(".text-get-turnover").val(turnover_get);

            $(".text-promotion-name").val(promotion_last_name);
            $(".text-last-promotion").val(promotion_last);
            $(".text-get-promotion").val(promotion_get);

            $(".text-cash-in").val(deposit);
            $(".text-cash-out").val(withdraw);
            $(".text-net-win").val(net_win);

            $(".select-member-id").val(recid);

            $(".modal-title").html('Manage Member Accounting');

            $("#myModal").modal("show");
        }
    }

    function recDelete(e) {
        //e.preventDefault();
        var recid = e.attr('data-id');
        $(".delete-id").val(recid);
        swal({
            title: "Are you sure to delete?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () {

            $("#form-delete").submit();
            // e.attr("href",url);
            // e.trigger("click");
        });
    }

    function get_last_promotion(recid) {
        if(recid > 0){
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_member_last_promotion.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                       // alert(recid);
                        $(".text-promotion-name").val(data[0]['promotion_name']);
                        $(".text-last-promotion").val(data[0]['promotion_date']);
                        $(".text-get-promotion").val(data[0]['promotion_get']);
                    }
                }
            });
        }

    }
    function get_last_turnover(recid) {
        if(recid > 0){
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_member_last_turnover.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(recid);
                        $(".text-turnover-amount").val(data[0]['turnover_amt']);
                        $(".text-last-turnover").val(data[0]['turnover_date']);
                        $(".text-get-turnover").val(data[0]['turnover_get']);
                    }
                }
            });
        }

    }
    function get_last_cash(recid) {
        if(recid > 0){
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_member_last_cash.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(recid);
                        $(".text-cash-in").val(data[0]['cash_in']);
                        $(".text-cash-out").val(data[0]['cash_out']);
                        $(".text-net-win").val(data[0]['net_win']);
                    }
                }
            });
        }

    }

    function notify() {
        // $.toast({
        //     title: 'Message Notify',
        //     subtitle: '',
        //     content: 'eror',
        //     type: 'success',
        //     delay: 3000,
        //     // img: {
        //     //     src: 'image.png',
        //     //     class: 'rounded',
        //     //     title: 'แจ้งการทำงาน',
        //     //     alt: 'Alternative'
        //     // },
        //     pause_on_hover: false
        // });
        var msg_ok = $(".msg-ok").val();
        var msg_error = $(".msg-error").val();
        if (msg_ok != '') {
            $.toast({
                title: 'Message notify',
                subtitle: '',
                content: msg_ok,
                type: 'success',
                delay: 3000,
                // img: {
                //     src: 'image.png',
                //     class: 'rounded',
                //     title: 'แจ้งการทำงาน',
                //     alt: 'Alternative'
                // },
                pause_on_hover: false
            });
        }
        if (msg_error != '') {
            $.toast({
                title: 'Message notify',
                subtitle: '',
                content: msg_error,
                type: 'danger',
                delay: 3000,
                // img: {
                //     src: 'image.png',
                //     class: 'rounded',
                //     title: 'แจ้งการทำงาน',
                //     alt: 'Alternative'
                // },
                pause_on_hover: false
            });
        }

    }

    function showtooltip(e) {
        var tooltip_text = '';
        var t
        if (e.val() > 0) {

            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_promotion_tooltip.php',
                'data': {'id': e.val()},
                'success': function (data) {
                    if (data.length > 0) {
                        tooltip_text = data[0]['description'];
                    }
                }
            });
            e.attr("title", tooltip_text);

        }

        //alert(e.val());
    }

    function show_pro_history(e) {
        var promotion = $(".find-promotion").val();
        var id = $(".user-recid").val();
        if (id) {
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'get_promotion_history.php',
                'data': {'id': id,'promotion_id': promotion},
                'success': function (data) {
                    if (data != '') {
                        $("table.table-promotion-history tbody").html(data);
                        $("#promotionHistoryModal").modal("show");
                    }else{
                        $("table.table-promotion-history tbody").html('');
                        $("#promotionHistoryModal").modal("show");
                    }
                }
            });
        }
    }

    function show_turnover_history(e) {
        var id = $(".user-recid").val();
        if (id) {
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'get_turnover_history.php',
                'data': {'id': id},
                'success': function (data) {
                    if (data != '') {
                        $("table.table-turnover-history tbody").html(data);
                        $("#turnoverHistoryModal").modal("show");
                    }else{
                        $("table.table-turnover-history tbody").html('');
                        $("#turnoverHistoryModal").modal("show");
                    }
                }
            });
        }
    }

    function show_deposit_history(e) {
        var id = $(".user-recid").val();
        if (id) {
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'get_deposit_history.php',
                'data': {'id': id},
                'success': function (data) {
                    if (data != '') {
                        $("table.table-deposit-history tbody").html(data);
                        $("#depositHistoryModal").modal("show");
                    }else{
                        $("table.table-deposit-history tbody").html('');
                        $("#depositHistoryModal").modal("show");
                    }
                }
            });
        }
    }

    function show_withdraw_history(e) {
        var id = $(".user-recid").val();
      //  alert(id);
        if (id) {
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'get_withdraw_history.php',
                'data': {'id': id},
                'success': function (data) {
                    if (data != '') {
                        $("table.table-withdraw-history tbody").html(data);
                        $("#withdrawHistoryModal").modal("show");
                    }else{
                        $("table.table-withdraw-history tbody").html('');
                        $("#withdrawHistoryModal").modal("show");
                    }
                }
            });
        }
    }

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>
