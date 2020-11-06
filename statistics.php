<?php
ob_start();
session_start();

//if (!isset($_SESSION['userid'])) {
//    header("location:loginpage.php");
//}
//echo date('H:i');return;
include "header.php";
include "models/BankCompanyModel.php";
include "total_statistic.php";
//include("models/PromotionModel.php");

$bank_data = getBankAccountmodel($connect);
$promotion_data = getPromotionmodel($connect);
$position_data = getPositionmodel($connect);
$per_check = checkPer($user_position, "is_bank", $connect);
if (!$per_check) {
    header("location:errorpage.php");
}

$noti_ok = '';
$noti_error = '';

if (isset($_SESSION['msg-success'])) {
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if (isset($_SESSION['msg-error'])) {
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}

?>
<input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
<input type="hidden" class="msg-error" value="<?= $noti_error ?>">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Statistics</h1>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_bank.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <h4 class="text-warning">Statistics</h4>
        <hr>

        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="">From Date</label>
                        <input type="text" class="form-control from-date" name="from_date" value="" autocomplete="off" placeholder="DD/MM/YYYY" required>
                    </div>
                    <div class="col-lg-3">
                        <label for="">To Date</label>
                        <input type="text" class="form-control to-date" name="to_date" value="" autocomplete="off" placeholder="DD/MM/YYYY" required>
                    </div>
                    <div class="col-lg-3">
                        <label for="">Promotion</label>
                        <select name="promotion_id" id="promotion" class="form-control promotion-id"
                                style="margin-left: 5px;">
                            <option value="0">--Select Promotion--</option>
                            <?php for ($i = 0; $i <= count($promotion_data) - 1; $i++): ?>
                                <option value="<?= $promotion_data[$i]['id'] ?>"><?= $promotion_data[$i]['name'] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="" style="color: white">ok</label><br />
                        <div class="btn btn-info btn-search">Search</div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-3"><h5>Cash In</h5></div>
                    <div class="col-lg-6"><input type="text" class="form-control cash-in" readonly value="0"></div>
                </div><div style="height: 2px;"></div>
                <div class="row">
                    <div class="col-lg-3"><h5>Cash Out</h5></div>
                    <div class="col-lg-6"><input type="text" class="form-control cash-out" readonly value="0"></div>
                </div><div style="height: 2px;"></div>
                <div class="row">
                    <div class="col-lg-3"><h5>Net Win</h5></div>
                    <div class="col-lg-6"><input type="text" class="form-control net-win" readonly value="0"></div>
                </div>
            </div>
            <div class="col-lg-6">
<!--                <div class="row">-->
<!--                    <div class="col-lg-12 text-center">-->
<!--                         <h4>My bank account</h4>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <br />-->
<!--                <div class="row">-->
<!--                    <div class="col-lg-6">-->
<!--                        <label for="">Bank Name</label>-->
<!--                        <select name="bank_id" id="" class="form-control bank-top-id" required>-->
<!--                            <option value="0">--Select Bank name--</option>-->
                            <?php //for ($i = 0; $i <= count($bank_data) - 1; $i++): ?>
<!--                                <option value="--><?php ////echo $bank_data[$i]['id'] ?><!--">--><?php ////echo $bank_data[$i]['name'] ?><!--</option>-->
                            <?php //endfor; ?>
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div class="col-lg-6">-->
<!--                        <label for="">Balance</label>-->
<!--                        <input type="text" class="form-control txt-top-balance" value="0" readonly>-->
<!--                    </div>-->
<!--                </div>-->
                <br />
<!--                <div class="row">-->
<!--                    <div class="col-lg-4"></div>-->
<!--                    <div class="col-lg-4">-->
<!--                        <div class="btn btn-primary btn-top-show-all">Show all account</div>-->
<!--                    </div>-->
<!--                    <div class="col-lg-4"></div>-->
<!--                </div>-->
                <br />
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_bank.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <h4 class="text-success">All Statistics</h4>
        <hr>

        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-3"><h5>Total Members</h5></div>
                    <div class="col-lg-6"><input type="text" class="form-control" readonly value="<?=$total_member?>"></div>
                </div>
                <div style="height: 2px;"></div>
                <div class="row">
                    <div class="col-lg-3"><h5>Cash In</h5></div>
                    <div class="col-lg-6"><input type="text" class="form-control" readonly value="<?=$total_cash_in?>"></div>
                </div>
                <div style="height: 2px;"></div>
                <div class="row">
                    <div class="col-lg-3"><h5>Cash Out</h5></div>
                    <div class="col-lg-6"><input type="text" class="form-control" readonly value="<?=$total_cash_out?>"></div>
                </div>
                <div style="height: 2px;"></div>
                <div class="row">
                    <div class="col-lg-3"><h5>Net Win</h5></div>
                    <div class="col-lg-6"><input type="text" class="form-control" readonly value="<?=$total_net_win?>"></div>
                </div>
                <div style="height: 2px;"></div>
                <div class="row">
                    <div class="col-lg-3"><h5>Promotion Get</h5></div>
                    <div class="col-lg-6"> <input type="text" class="form-control" readonly value="<?=$total_promotion_get?>"></div>
                </div>
                <div style="height: 2px;"></div>
                <div class="row">
                    <div class="col-lg-3">
                        <select name="promotion_id" id="promotion-bottom" class="form-control promotion-bottom"
                                style="margin-left: 5px;">
                            <option value="0">--Select Promotion--</option>
                            <?php for ($i = 0; $i <= count($promotion_data) - 1; $i++): ?>
                                <option value="<?= $promotion_data[$i]['id'] ?>"><?= $promotion_data[$i]['name'] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-lg-6"> <input type="text" class="form-control txt-filter-get" readonly value="<?=$total_promotion_get?>"></div>
                </div>
            </div>
            <div class="col-lg-6" style="border-left: 1px dashed gray">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h4>My bank account</h4>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-6">
                        <label for="">Bank Name</label>
                        <select name="bank_id" id="" class="form-control bank-bottom-id" required>
                            <option value="0">--Select Bank name--</option>
                            <?php for ($i = 0; $i <= count($bank_data) - 1; $i++): ?>
                                <option value="<?= $bank_data[$i]['id'] ?>"><?= $bank_data[$i]['name'] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label for="">Balance</label>
                        <input type="text" class="form-control txt-bottom-balance" value="0" readonly>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <div class="btn btn-primary btn-bottom-show-all">Show all account</div>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
                <br />
            </div>
        </div>
    </div>
    <br />
</div>
<br />

<?php
include "footer.php";
?>
<script>
    notify();
    $(".from-date,.to-date").datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    // $(".from-date").datepicker({
    //     dateFormat: 'dd/mm/yy',
    //     todayHighlight: true,
    //     autoclose: true
    // });
    // $(".to-date").datepicker({
    //     dateFormat: 'dd/mm/yy',
    //     todayHighlight: true,
    //     autoclose: true
    // });

    $(".to-date").on("change", function () {
        var s_date = $(".from-date").val();
        if ($(this).val() < s_date) {
            $(this).val(s_date);
        }
    });

    $(".btn-top-show-all").click(function(){
      //  alert();
        $(".bank-top-id").val(0).change();

        $.ajax({
            'type': 'post',
            'dataType': 'html',
            'async': false,
            'url': 'balance_all_fetch.php',
            'success': function (data) {
               $(".txt-top-balance").val(data);
            }
        });
    });

    $(".btn-top-show-all").trigger('click');

    $(".bank-top-id").change(function () {
        var f_date = $(".from-date").val();
        var t_date = $(".to-date").val();
        var promotion = $(".promotion").val();

        var bank_id = $(this).val();
        if(bank_id > 0){
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'balance_bank_fetch.php',
                'data': {'id': bank_id, 'from_date': f_date, 'to_date': t_date, 'promotion_id': promotion},
                'success': function (data) {
                  //  alert(data);
                    $(".txt-top-balance").val(data);
                }
            });
        }
    });

    $(".btn-bottom-show-all").click(function(){
        //  alert();
        $(".bank-bottom-id").val(0).change();
        $.ajax({
            'type': 'post',
            'dataType': 'html',
            'async': false,
            'url': 'balance_all_fetch.php',
            'success': function (data) {
                $(".txt-bottom-balance").val(data);
            }
        });
    });

    $(".btn-bottom-show-all").trigger('click');

    $(".bank-bottom-id").change(function () {
        var bank_id = $(this).val();
        if(bank_id > 0){
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'balance_bank_fetch.php',
                'data': {'id': bank_id},
                'success': function (data) {
                   // alert(data);
                    $(".txt-bottom-balance").val(data);
                }
            });
        }
    });

    $(".promotion-bottom").change(function(){
        var promotion = $(this).val();
        if(promotion > 0){
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'total_statistic_pro_fetch.php',
                'data': {'promotion_id': promotion},
                'success': function (data) {
                    if(data.length > 0){
                        $(".txt-filter-get").val(data[0]['total_get']);
                    }
                }
            });
        }
    });

    $(".btn-search").click(function(){
        var f_date = $(".from-date").val();
        var t_date = $(".to-date").val();
        var promotion = $(".promotion-id").val();

        //if(f_date != '' && t_date != ''){

            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'total_statistic_fetch.php',
                'data': {'from_date': f_date, 'to_date': t_date, 'promotion_id': promotion},
                'success': function (data) {
                   if(data.length > 0){
                       $(".cash-in").val(data[0]['total_cash_in']);
                       $(".cash-out").val(data[0]['total_cash_out']);
                       $(".net-win").val(data[0]['total_net_win']);
                   }
                }
            });
       // }

    });

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
                title: 'แจ้งเตือนการทำงาน',
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
                title: 'แจ้งเตือนการทำงาน',
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
</script>
