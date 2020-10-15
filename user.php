<?php
ob_start();
session_start();
//date_default_timezone_set('Asia/Bangkok');
if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
//echo date('H:i');return;
include "header.php";
//include("models/PositionModel.php");

$position_data = getPositionmodel($connect);
$per_check = checkPer($user_position,"is_user", $connect);
if(!$per_check){
    header("location:errorpage.php");
}


?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Users</h1>
    <div class="btn-group">
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" onclick="showadduser($(this))"><i
                    class="fas fa-plus-circle fa-sm text-white-50"></i> Add New</a>
        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_user.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Display Name</th>
                    <th>Username</th>
                    <th>Position</th>
                    <th style="width:25%">-</th>
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
            <form action="add_user_data.php" id="form-user" method="post">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Display Name</label>
                            <input type="text" class="form-control display-name" name="displayname" value=""
                                   placeholder="Display name">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Username</label>
                            <input type="text" class="form-control username" name="username" value=""
                                   placeholder="Username">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Password</label>
                            <input type="password" class="form-control password" name="password" value=""
                                   placeholder="Password">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Position</label>
                            <select name="position_id" id="" class="form-control position-id">
                                <option value="0">--Select Position--</option>
                                <?php for ($i = 0; $i <= count($position_data) - 1; $i++): ?>
                                    <option value="<?= $position_data[$i]['id'] ?>"><?= $position_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <br>
<!--                    <h3>User Roles</h3>-->
<!--                    <hr>-->
<!--                    <div class="row">-->
<!--                        <div class="col-lg-6">-->
<!--                            <div class="form-check">-->
<!--                                <div class="form-group">-->
<!--                                    <div class="custom-control custom-checkbox small">-->
<!--                                        <input type="checkbox" name="is_member" class="custom-control-input"-->
<!--                                               id="is_member" onchange="checkboxChange($(this))">-->
<!--                                        <label class="custom-control-label" for="is_member">Member</label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <div class="custom-control custom-checkbox small">-->
<!--                                        <input type="checkbox" name="is_accounting" class="custom-control-input"-->
<!--                                               id="is_accounting" onchange="checkboxChange($(this))">-->
<!--                                        <label class="custom-control-label" for="is_accounting">Accounting</label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <div class="custom-control custom-checkbox small">-->
<!--                                        <input type="checkbox" name="is_promotion" class="custom-control-input" id="is_promotion"-->
<!--                                               onchange="checkboxChange($(this))">-->
<!--                                        <label class="custom-control-label" for="is_promotion">Promotion Setting</label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <div class="custom-control custom-checkbox small">-->
<!--                                        <input type="checkbox" name="is_capital" class="custom-control-input" id="is_capital"-->
<!--                                               onchange="checkboxChange($(this))">-->
<!--                                        <label class="custom-control-label" for="is_capital">Capital</label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-lg-6">-->
<!--                            <div class="form-check">-->
<!--                                <div class="form-group">-->
<!--                                    <div class="custom-control custom-checkbox small">-->
<!--                                        <input type="checkbox" name="is_bank" class="custom-control-input" id="is_bank"-->
<!--                                               onchange="checkboxChange($(this))">-->
<!--                                        <label class="custom-control-label" for="is_bank">Bank</label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <div class="custom-control custom-checkbox small">-->
<!--                                        <input type="checkbox" name="is_user" class="custom-control-input"-->
<!--                                               id="is_user" onchange="checkboxChange($(this))">-->
<!--                                        <label class="custom-control-label" for="is_user">User</label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <div class="custom-control custom-checkbox small">-->
<!--                                        <input type="checkbox" name="is_all" class="custom-control-input" id="is_all">-->
<!--                                        <label class="custom-control-label" for="is_all">All</label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                    </div>-->
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
    function showadduser(e) {
        $(".user-recid").val();
        $(".display-name").val('');
        $(".username").val('');
        $(".position-id").val(0).change();
        $("#myModal").modal("show");
    }

    var options = {
        onComplete: function (cep, event, field) {
            var full_time = cep.split(":");
            var hh = full_time[0];
            var mm = full_time[1];

            if (hh >= 24 || hh < 0) {
                field.val('00:00');
                $(".msg-time").html("รูปแบบเวลาไม่ถูกต้อง");
                setTimeout(function () {
                    $(".msg-time").show();
                }, 3000);
                return false;
            } else {
                $(".msg-time").html("");
                $(".msg-time").hide();
            }
            if (mm >= 59 || mm < 0) {
                field.val('00:00');
                $(".msg-time").html("รูปแบบเวลาไม่ถูกต้อง");
                setTimeout(function () {
                    $(".msg-time").show();
                }, 3000);
                return false;
            } else {
                $(".msg-time").html("");
                $(".msg-time").hide();
            }
        },
        onKeyPress: function (cep, event, currentField, options) {
            console.log('A key was pressed!:', cep, ' event: ', event,
                'currentField: ', currentField, ' options: ', options);
        },
        onChange: function (cep) {
            console.log('cep changed! ', cep);
        },
        onInvalid: function (val, e, f, invalid, options) {
            var error = invalid[0];
            console.log("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
        }
    };
    $("#start-time").mask("00:00", options);
    $("#end-time").mask("00:00", options);
    $("#dataTable").dataTable({
        "processing": true,
        "serverSide": true,
        "order": [[1, "asc"]],
        "ajax": {
            url: "user_fetch.php",
            type: "POST"
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },

        ],
    });

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

    function showupdate(e) {
        var recid = e.attr("data-id");
        if (recid != '') {
            var display_name = '';
            var username = '';
            var branch = '';
            var stime = '';
            var ntime = '';
            var branch_price = '';
            var position = 0;
            var is_dash = '';
            var is_prod = '';
            var is_return = '';
            var is_history = '';
            var is_customer = '';
            var is_tool = '';
            var is_user = '';
            var is_all = '';
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_user_update.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(data[0]['display_name']);
                        display_name = data[0]['display_name'];
                        username = data[0]['username'];
                        branch = data[0]['branch'];
                        branch_price = data[0]['branch_price'];
                        stime = data[0]['use_start'];
                        ntime = data[0]['use_end'];
                        position = data[0]['position_id'];
                        // is_dash = data[0]['is_dash'];
                        // is_prod = data[0]['is_prod'];
                        // is_return = data[0]['is_return'];
                        // is_history = data[0]['is_history'];
                        // is_customer = data[0]['is_customer'];
                        // is_tool = data[0]['is_tool'];
                        // is_user = data[0]['is_user'];
                        // is_all = data[0]['is_all'];
                    }
                }
            });

            $(".user-recid").val(recid);
            $(".display-name").val(display_name);
            $(".username").val(username);
            $("#select-branch").val(branch).change();
            $("#select-branch-price").val(branch_price).change();
            $("#start-time").val(stime);
            $("#end-time").val(ntime);
            $(".position-id").val(position).change();

            // if (is_dash == 1) {
            //     $("#is_dashboard").prop("checked", "checked");
            // }
            // if (is_prod == 1) {
            //     $("#is_product").prop("checked", "checked");
            // }
            // if (is_return == 1) {
            //     $("#is_return").prop("checked", "checked");
            // }
            // if (is_history == 1) {
            //     $("#is_history").prop("checked", "checked");
            // }
            // if (is_customer == 1) {
            //     $("#is_customer").prop("checked", "checked");
            // }
            // if (is_tool == 1) {
            //     $("#is_tool").prop("checked", "checked");
            // }
            // if (is_user == 1) {
            //     $("#is_user").prop("checked", "checked");
            // }
            // if (is_all == 1) {
            //     $("#is_all").prop("checked", "checked");
            // }

            $(".username").prop('disabled', 'disabled');
            $(".password").prop('disabled', 'disabled');

            $(".modal-title").html('Update User');

            $("#myModal").modal("show");
        }
    }

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
</script>
