<?php
ob_start();
session_start();
//date_default_timezone_set('Asia/Yangon');
if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
//echo date('H:i');return;
include "header.php";

$position_data = getPositionmodel($connect);
$per_check = checkPer($user_position,"is_position", $connect);
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
    <h1 class="h3 mb-0 text-gray-800">Position</h1>
    <div class="btn-group">
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" onclick="showaddposition($(this))"><i
                class="fas fa-plus-circle fa-sm text-white-50"></i> Add New</a>
        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_position.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
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
            <form action="add_position_data.php" id="form-user" method="post">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">Add New Position</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Name</label>
                            <input type="text" class="form-control bank-name" name="bank_name" value=""
                                   placeholder="Name">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control description" id="" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <br>
                    <h3>User Roles</h3>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-check">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="is_member" class="custom-control-input"
                                               id="is_member" onchange="checkboxChange($(this))">
                                        <label class="custom-control-label" for="is_member">Member</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="is_accounting" class="custom-control-input"
                                               id="is_accounting" onchange="checkboxChange($(this))">
                                        <label class="custom-control-label" for="is_accounting">Accounting</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="is_promotion" class="custom-control-input" id="is_promotion"
                                               onchange="checkboxChange($(this))">
                                        <label class="custom-control-label" for="is_promotion">Promotion Setting</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="is_capital" class="custom-control-input" id="is_capital"
                                               onchange="checkboxChange($(this))">
                                        <label class="custom-control-label" for="is_capital">Capital</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="is_company_account" class="custom-control-input" id="is_company_account"
                                               onchange="checkboxChange($(this))">
                                        <label class="custom-control-label" for="is_company_account">Bank Account</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="is_bank" class="custom-control-input" id="is_bank"
                                               onchange="checkboxChange($(this))">
                                        <label class="custom-control-label" for="is_bank">Bank</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="is_user" class="custom-control-input"
                                               id="is_user" onchange="checkboxChange($(this))">
                                        <label class="custom-control-label" for="is_user">User</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="is_position" class="custom-control-input"
                                               id="is_position" onchange="checkboxChange($(this))">
                                        <label class="custom-control-label" for="is_position">User</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="is_statistics" class="custom-control-input"
                                               id="is_statistics" onchange="checkboxChange($(this))">
                                        <label class="custom-control-label" for="is_statistics">Statistics</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="is_all" class="custom-control-input" id="is_all">
                                        <label class="custom-control-label" for="is_all">All</label>
                                    </div>
                                </div>
                            </div>
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
<?php
include "footer.php";
?>
<script>
    notify();
    $("#is_all").change(function () {
        if ($(this).is(":checked")) {
            //  alert("on");
            $("#myModal input[type='checkbox']").each(function () {
                $(this).prop("checked", "checked");
            });
        } else {
            //alert("off");
            $("#myModal input[type='checkbox']").each(function () {
                $(this).prop("checked", "");
            });
        }
    });
    function checkboxChange(e) {
        var cnt = $("#myModal input[type='checkbox']").length - 1;
        // alert(cnt);
        var i = 0;
        $("#myModal input[type='checkbox']").each(function () {
            if ($(this).is(":checked")) {
                i += 1;
            }
            ;
        });
        // alert(i);
        if (i < cnt) {
            $("#is_all").prop("checked", "");
        } else if (i == cnt) {
            if ($("#is_all").is(":checked")) {
                $("#is_all").prop("checked", "");
            } else {
                $("#is_all").prop("checked", "checked");
            }

        } else {
            $("#is_all").prop("checked", "checked");
        }

    }
    function showaddposition(e) {
        $(".user-recid").val();
        $(".bank-name").val('');
        $(".description").val('');
        $("#myModal").modal("show");
    }

    $("#dataTable").dataTable({
        "processing": true,
        "serverSide": true,
        "order": [[1, "asc"]],
        "ajax": {
            url: "position_fetch.php",
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
           // alert(recid);
            var name = '';
            var description = '';
            var is_member = 0;
            var is_accounting = 0;
            var is_promotion = 0;
            var is_capital = 0;
            var is_bank = 0;
            var is_user = 0;
            var is_position = 0;
            var is_bank_account = 0;
            var is_statistics = 0;
            var is_all = 0;


            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_position_update.php',
                'data': {'id': recid},
                'success': function (data) {
                   // alert(data);
                    if (data.length > 0) {
                        name = data[0]['name'];
                        description = data[0]['description'];
                        is_member = data[0]['is_member'];
                        is_accounting = data[0]['is_accounting'];
                        is_promotion = data[0]['is_promotion'];
                        is_capital = data[0]['is_capital'];
                        is_bank = data[0]['is_bank'];
                        is_user = data[0]['is_user'];
                        is_position = data[0]['is_position'];
                        is_bank_account = data[0]['is_company_account'];
                        is_all = data[0]['is_all'];
                        is_statistics = data[0]['is_statistics'];
                    }
                },
                'error': function(err){
                    alert('error');
                }
            });

            $(".user-recid").val(recid);
            $(".bank-name").val(name);
            $(".description").val(description);

            if (is_member == 1) {
                $("#is_member").prop("checked", "checked");
            }
            if (is_accounting == 1) {
                $("#is_accounting").prop("checked", "checked");
            }
            if (is_promotion == 1) {
                $("#is_promotion").prop("checked", "checked");
            }
            if (is_capital == 1) {
                $("#is_capital").prop("checked", "checked");
            }
            if (is_bank == 1) {
                $("#is_bank").prop("checked", "checked");
            }
            if (is_user == 1) {
                $("#is_user").prop("checked", "checked");
            }
            if (is_position == 1) {
                $("#is_position").prop("checked", "checked");
            }
            if (is_bank_account == 1) {
                $("#is_company_account").prop("checked", "checked");
            }
            if (is_statistics == 1) {
                $("#is_statistics").prop("checked", "checked");
            }
            if (is_all == 1) {
                $("#is_all").prop("checked", "checked");
            }

            $(".modal-title").html('Update Position');

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
</script>
