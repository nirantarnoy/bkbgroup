<?php
ob_start();
session_start();
//date_default_timezone_set('Asia/Yangon');
if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
//echo date('H:i');return;
include "header.php";
include("models/BankModel.php");

$position_data = getPositionmodel($connect);
$per_check = checkPer($user_position, "is_member", $connect);
if (!$per_check) {
    header("location:errorpage.php");
}



$bank_data = getBankmodel($connect);
$noti_ok = '';
$noti_error = '';

if (!empty($_SESSION['msg-success'])) {
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if (isset($_SESSION['msg-error'])) {
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}

//echo date('Y-d-m H:m:i',strtotime("-30 minutes"));
?>
<input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
<input type="hidden" class="msg-error" value="<?= $noti_error ?>">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">SKM Members</h1>
    <div class="btn-group">
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"
           onclick="showaddmember($(this))"><i
                    class="fas fa-plus-circle fa-sm text-white-50"></i> Add New</a>
        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_skmmember.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ActiveDate</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Bank Name</th>
                    <th>Bank Account</th>
                    <th>ID_Number</th>
                    <th>LV2</th>
                    <th>-</th>
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
            <form action="add_skmmember_data.php" id="form-user" method="post" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">Add New SKM Member</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="0">
                    <input type="hidden" name="action_type" class="action-type" value="create">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Account ID</label>
                            <input type="text" class="form-control account-id" name="account_id" value=""
                                   placeholder="Account ID" required onchange="check_dup_accountid($(this))">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Name</label>
                            <input type="text" class="form-control member-name" name="member_name" value=""
                                   placeholder="Name" onchange="check_dup_member($(this))" required>
                        </div>
                        <div class="col-lg-4">
                            <label for="">Date Of Birth</label>
                            <input type="text" class="form-control member-dob" name="member_dob" value=""
                                   placeholder="none">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Phone</label>
                            <input type="text" class="form-control phone" name="phone" value=""
                                   placeholder="Phone" onchange="check_dup_phone($(this))" required>
                        </div>
                        <div class="col-lg-4">
                            <label for="">Bank Name</label>
                            <select name="bank_id" id="" class="form-control bank-id" required>
                                <option value="">--Select Bank name--</option>
                                <?php for ($i = 0; $i <= count($bank_data) - 1; $i++): ?>
                                    <option value="<?= $bank_data[$i]['id'] ?>"><?= $bank_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="">Bank Account</label>
                            <input type="text" class="form-control bank-account" name="bank_account" value=""
                                   placeholder="Bank account" required onchange="check_dup_bank($(this))">
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">ID Number</label>
                            <input type="text" class="form-control id-number" name="id_number" value=""
                                   placeholder="ID Number">
                        </div>
                        <div class="col-lg-4">
                            <label for="">LV2</label>
                            <select name="is_level2" id="" class="form-control is-level2">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
<!--                    <hr>-->
<!--                    <div class="row">-->
<!--                        <div class="col-lg-6">-->
<!--                            <label for="">ID Card Picture</label>-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-12">-->
<!---->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-12">-->
<!--                                    <div class="show-card-photo">-->
<!--                                        <img src="" class="card-photo" width="100%" alt="">-->
<!--                                    </div>-->
<!--                                    <br />-->
<!--                                    <div class="btn btn-danger btn-delete-card-photo" style="display: ">Delete card photo</div>-->
<!--                                    <div class="btn-add-card-photo">-->
<!--                                        <input type="file" name="file_card">-->
<!--                                    </div>-->
<!---->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
<!--                        <div class="col-lg-6">-->
<!--                            <label for="">Bank Account Picture</label>-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-12">-->
<!---->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-12">-->
<!--                                    <div class="show-bank-photo">-->
<!--                                        <img src="" class="bank-photo" width="100%" alt="">-->
<!--                                    </div>-->
<!--                                    <br />-->
<!--                                    <div class="btn btn-danger btn-delete-bank-photo" style="display: ">Delete bank photo</div>-->
<!--                                    <div class="btn-add-bank-photo">-->
<!--                                        <input type="file" name="file_bank">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
<!--                    </div>-->

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-save" data-dismiss="modalx"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<form action="delete_idcard_photo.php" method="post" id="form-delete-photo">
    <input type="hidden" class="delete-photo-id" name="delete_photo_id" value="">
    <input type="hidden" class="delete-photo" name="delete_photo" value="">
    <input type="hidden" class="delete-bank-photo" name="delete_photo" value="">
</form>
<?php
include "footer.php";
?>

<script>
    notify();

    $(".member-dob").datepicker({
        dateFormat: 'dd/mm/yy',
        todayHighlight: true,
        autoclose: true
    });
    $(".bank-account,.phone").on("keypress", function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ""));
        if ((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $(".bank-account,.phone").on('paste', function (event) {
        if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
            event.preventDefault();
        }
    });
    function showaddmember(e) {
        $(".user-recid").val();
        $(".action-type").val('create');
        $(".account-id").val('');
        $(".member-name").val('');
        $(".member-dob").val('Date of birth');
        $(".phone").val('');
        $(".id-number").val('');
        $(".bank-account").val('');
        $(".bank-id").val(0).change();
        $(".is-level2").val(0).change();

        $(".card-photo").attr('src','');
        $(".bank-photo").attr('src','');

        $(".btn-delete-card-photo").hide();
        $(".btn-delete-bank-photo").hide();

        $("div.btn-add-card-photo").show();
        $("div.btn-add-bank-photo").show();

        $("#myModal").modal("show");
    }

    $("#dataTable").dataTable({
        "processing": true,
        "serverSide": true,
        "order": [[1, "asc"]],
        "pageLength": 25,
        "ajax": {
            url: "skmmember_fetch.php",
            type: "POST"
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },

        ],
    });

    function showupdate(e) {
        var recid = e.attr("data-id");
        if (recid != '') {
            var account_id = '';
            var name = '';
            var dob = null;
            var phone = '';
            var id_number = '';
            var bank_id = -1;
            var bank_account = '';
            var is_level2 = 0;
            var card_photo = '';
            var bank_photo = '';

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
                        card_photo = data[0]['card_photo'];
                        bank_photo = data[0]['bank_photo'];
                    }
                }
            });

            $(".user-recid").val(recid);
            $(".action-type").val('update');
            $(".account-id").val(account_id);
            $(".member-name").val(name);
            $(".member-dob").val(dob);
            $(".phone").val(phone);
            $(".id-number").val(id_number);
            $(".bank-id").val(bank_id).change();
            $(".bank-account").val(bank_account);
            $(".is-level2").val(is_level2).change();

            $(".delete-photo-id").val(recid);

            $(".card-photo").attr("src", "uploads/idcard_photo/"+card_photo);
            $(".bank-photo").attr("src", "uploads/bank_photo/"+bank_photo);
            if(card_photo != ''){
                $("div.btn-add-card-photo").hide();
                $(".btn-delete-card-photo").show();
                $(".delete-photo").val(card_photo);
            }else{
                $("div.btn-add-card-photo").show();
                $(".btn-delete-card-photo").hide();
                $(".delete-photo").val('');
            }
            if(bank_photo != ''){
                $("div.btn-add-bank-photo").hide();
                $(".btn-delete-bank-photo").show();
                $(".delete-bank-photo").val(bank_photo);
            }else{
                $("div.btn-add-bank-photo").show();
                $(".btn-delete-bank-photo").hide();
                $(".delete-bank-photo").val('');
            }

            $(".modal-title").html('Update SKM Member');

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
    function check_dup_member(e) {
        if(e.val() != ''){
           // alert(e.val())
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                //'async': false,
                'url': 'check_member.php',
                'data': {'name': e.val()},
                'success': function (data) {
                    if (data > 0) {
                        e.val('');
                        e.css("border","1px solid red");
                        e.attr('placeholder','This name has already.');
                    }else{
                        e.css("border","1px solid gray");
                    }
                }
            });
        }
    }
    function check_dup_phone(e) {
        if(e.val() != ''){
            // alert(e.val())
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                //'async': false,
                'url': 'check_phone.php',
                'data': {'phone': e.val()},
                'success': function (data) {
                    if (data > 0) {
                        e.val('');
                        e.css("border","1px solid red");
                        e.attr('placeholder','This phone has already.');
                    }else{
                        e.css("border","1px solid gray");
                    }
                }
            });
        }
    }
    function check_dup_bank(e) {
        if(e.val() != ''){
            // alert(e.val())
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                //'async': false,
                'url': 'check_bank_account.php',
                'data': {'bank_account': e.val()},
                'success': function (data) {
                    if (data > 0) {
                        e.val('');
                        e.css("border","1px solid red");
                        e.attr('placeholder','This account has already.');
                    }else{
                        e.css("border","1px solid gray");
                    }
                }
            });
        }
    }
    function check_dup_accountid(e) {
        if(e.val() != ''){
            // alert(e.val())
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                //'async': false,
                'url': 'check_member_id.php',
                'data': {'account_id': e.val()},
                'success': function (data) {
                    if (data > 0) {
                        e.val('');
                        e.css("border","1px solid red");
                        e.attr('placeholder','This account id has already.');
                    }else{
                        e.css("border","1px solid gray");
                    }
                }
            });
        }
    }
    $(".btn-delete-card-photo").click(function(){
        if(confirm('Are you sure for delete?')){
            //$("form#form-delete-photo").submit();
            var recid = $(".delete-photo-id").val();
            var photo = $(".delete-photo").val();
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'delete_member_photo.php',
                'data': {'delete_photo_id': recid,'delete_photo': photo},
                'success': function (data) {
                    if (data == 1) {
                        $("div.photo-empty").show();
                        $("div.btn-add-card-photo").show();
                        $(".btn-delete-card-photo").hide();
                        $(".show-card-photo").hide();

                        $(".delete-photo").val('');
                        $(".card-photo").hide();
                    }else{
                        $("div.photo-empty").hide();
                        $("div.btn-add-card-photo").hide();
                        $(".btn-delete-card-photo").show();
                        $(".show-card-photo").show();

                    }
                }
            });
        }
    })

    $(".btn-delete-bank-photo").click(function(){
        if(confirm('Are you sure for delete?')){
            //$("form#form-delete-photo").submit();
            var recid = $(".delete-photo-id").val();
            var photo = $(".delete-bank-photo").val();

            // alert(recid);
            // alert(photo);
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'delete_member_bank_account.php',
                'data': {'delete_photo_id': recid,'delete_photo': photo},
                'success': function (data) {
                    if (data == 1) {
                        $("div.btn-add-bank-photo").show();
                        $(".btn-delete-bank-photo").hide();
                        $(".show-bank-photo").hide();

                        $(".delete-photo").val('');
                        $(".bank-photo").hide();
                    }else{
                        $("div.btn-add-bank-photo").hide();
                        $(".btn-delete-bank-photo").show();
                        $(".show-bank-photo").show();

                    }
                }
            });
        }
    })
</script>
