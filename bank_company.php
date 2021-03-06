<?php
ob_start();
session_start();

//if (!isset($_SESSION['userid'])) {
//    header("location:loginpage.php");
//}
//echo date('H:i');return;
include "header.php";
include "models/BankModel.php";
include "models/BankCompanyModel.php";


$bank_data = getBankmodel($connect);
$bank_account_data = getBankAccountmodel($connect);
$position_data = getPositionmodel($connect);
$per_check = checkPer($user_position,"is_bank", $connect);
if(!$per_check){
    header("location:errorpage.php");
}

$noti_ok = '';
$noti_error = '';

if(isset($_SESSION['msg-success'])){
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if(isset($_SESSION['msg-error'])){
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}

?>
<input type="hidden" class="msg-ok" value="<?=$noti_ok?>">
<input type="hidden" class="msg-error" value="<?=$noti_error?>">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">My Bank Account</h1>
    <div class="btn-group">
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" onclick="showaddbank($(this))"><i
                class="fas fa-plus-circle fa-sm text-white-50"></i> Add New</a>
        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_bank_company.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Account</th>
                    <th>Bank Name</th>
                    <th style="text-align: right">Balance</th>
                    <th style="width: 25%">-</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add_bank_company_data.php" id="form-user" method="post">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">Add New Account</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Name</label>
                            <input type="text" class="form-control account-name" name="account_name" value=""
                                   placeholder="Account name">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Account number</label>
                            <input type="text" class="form-control bank-account" name="bank_account" value=""
                                   placeholder="Account number">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Bank Name</label>
                            <select name="bank_id" id="" class="form-control bank-id" required>
                                <option value="">--Select Bank name--</option>
                                <?php for ($i = 0; $i <= count($bank_data) - 1; $i++): ?>
                                    <option value="<?= $bank_data[$i]['id'] ?>"><?= $bank_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Adjustment Amount</label>
                            <input type="text" class="form-control adjust-amount" name="adjust_amount" value="0" >
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Balance</label>
                            <input type="text" class="form-control balance-account" name="" value="" readonly >
                        </div>
                    </div>
                    <br>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-save" data-dismiss="modalx"><i class="fa fa-save"></i> Save </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="historyModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color: #1c606a">Bank transaction history <span style="color: red" class="bank-name-display"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <input type="hidden" class="bank-history-id" value="0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="historydataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Id member</th>
                                    <th>Action</th>
                                    <th>User</th>
                                    <th>Amount</th>
<!--                                    <th>Balance</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal" id="membertransModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color: #1c606a">Member transaction <span style="color: red" class="member-id-display"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <input type="hidden" class="member-history-id" value="0">
                            <table class="table table-bordered" id="membertransdataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Amount</th>
                                    <!--                                    <th>Balance</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include "footer.php";
?>
<script>
    notify();
    function showaddbank(e) {
        $(".user-recid").val();
        $(".bank-account").val('');
        $(".account-name").val('');
        $(".bank-id").val(0).change();
        $(".balance-account").val(0);
        $("#myModal").modal("show");
    }

    $("#dataTable").dataTable({
        "processing": true,
        "serverSide": true,
        "order": [[1, "asc"]],
        "pageLength": 25,
        "ajax": {
            url: "bank_company_fetch.php",
            type: "POST"
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },

        ],
    });
    $("#historydataTable").append('<tfoot><th></th><th></th><th></th><th></th><th></th><th style="text-align: right"></th></tfoot>');
    var historydataTable = $("#historydataTable").DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[1, "asc"]],
        "pageLength": 25,
        "ajax": {
            url: "bank_trans_fetch.php",
            type: "POST",
            data: function (data) {
                data.searchId = $('.bank-history-id').val();
            }
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },
            {
                targets: [5],
                className: 'text-right'
            },
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            var total = api
                .column(5)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                    //return a + a;
                }, 0 );
            var all_total = addCommas(parseFloat(total));
            // data = api.column(3, { page: 'current'} ).data();
            // pageTotal = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) : 0;

            // Update footer
            // var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '£' ).display;
            $( api.column(4).footer() ).html('<p style="text-align: right">Total</p>');
            $( api.column(5).footer() ).html(all_total);
        }
    });

    $("#membertransdataTable").append('<tfoot><th></th><th></th><th></th><th style="text-align: right"></th></tfoot>');
    var membertransdataTable = $("#membertransdataTable").DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[1, "asc"]],
        "pageLength": 100,
        "ajax": {
            url: "member_trans_fetch.php",
            type: "POST",
            data: function (data) {
                data.searchId = $('.member-history-id').val();
            }
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },
            {
                targets: [3],
                className: 'text-right'
            },
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            var total = api
                .column(3)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                    //return a + a;
                }, 0 );
            var all_total = addCommas(parseFloat(total));
            // data = api.column(3, { page: 'current'} ).data();
            // pageTotal = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) : 0;

            // Update footer
            // var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '£' ).display;
            $( api.column(2).footer() ).html('<p style="text-align: right">Total</p>');
            $( api.column(3).footer() ).html(all_total);
        }
    });
    function showmembertrans(e){
        var member_id = e.attr('data-var');
        var id_number = e.attr('data-id');
        if(member_id > 0){
            $(".member-history-id").val(member_id);
            $(".member-id-display").text(id_number);
            $("#membertransModal").modal("show");
            membertransdataTable.draw();
        }
    }
    function showupdate(e) {
        var recid = e.attr("data-id");
        if (recid != '') {
            var account_name = '';
            var bank_account = '';
            var bank_id = 0;
            var balance_acc = 0;
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_bank_company_update.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(data[0]['display_name']);
                        account_name = data[0]['account_name'];
                        bank_account = data[0]['bank_account'];
                        bank_id = data[0]['bank_id'];
                        balance_acc = data[0]['balance'];
                    }
                }
            });

            $(".user-recid").val(recid);
            $(".account-name").val(account_name)
            $(".bank-account").val(bank_account);
            $(".bank-id").val(bank_id).change();
            $(".balance-account").val(balance_acc);

            $(".modal-title").html('Update Company Account');

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
    function showhistory(e){
        var id = e.attr('data-id');
        var name = e.attr('data-var');
        if(id){
            $(".bank-history-id").val(id);
            historydataTable.draw();
            $(".bank-name-display").html(name);
            $("#historyModal").modal('show');
        }else{
            $(".bank-name-display").html('');
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
        if(msg_ok != ''){
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
        if(msg_error != ''){
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
