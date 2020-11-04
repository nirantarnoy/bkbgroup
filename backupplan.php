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
    <h1 class="h3 mb-0 text-gray-800">Backup Schedule</h1>
<!--    <div class="btn-group">-->
<!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"-->
<!--           onclick="showaddmember($(this))"><i-->
<!--                class="fas fa-plus-circle fa-sm text-white-50"></i> Add New</a>-->
<!--        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
<!--    </div>-->

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_member.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <div class="row">
            <div class="col-lg-12">
                <label for="">Schedule Type</label>
                <select name="bank_id" id="" class="form-control bank-id" required>
                    <option value="">--Select Bank name--</option>
                    <?php for ($i = 0; $i <= count($bank_data) - 1; $i++): ?>
                        <option value="<?= $bank_data[$i]['id'] ?>"><?= $bank_data[$i]['name'] ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <label for="">Week</label>
                <select name="bank_id" id="" class="form-control bank-id" required>
                    <option value="">--Select Bank name--</option>
                    <?php for ($i = 0; $i <= count($bank_data) - 1; $i++): ?>
                        <option value="<?= $bank_data[$i]['id'] ?>"><?= $bank_data[$i]['name'] ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <label for="">Day</label>
                <select name="bank_id" id="" class="form-control bank-id" required>
                    <option value="">--Select Bank name--</option>
                    <?php for ($i = 0; $i <= count($bank_data) - 1; $i++): ?>
                        <option value="<?= $bank_data[$i]['id'] ?>"><?= $bank_data[$i]['name'] ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <hr />
        <h4>Task transaction</h4>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="add_member_data.php" id="form-user" method="post" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">Add New Member</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
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
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">ID Card Picture</label>
                            <div class="row">
                                <div class="col-lg-12">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="show-card-photo">
                                        <img src="" class="card-photo" width="100%" alt="">
                                    </div>
                                    <br />
                                    <div class="btn btn-danger btn-delete-card-photo" style="display: ">Delete card photo</div>
                                    <div class="btn-add-card-photo">
                                        <input type="file" name="file_card">
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <label for="">Bank Account Picture</label>
                            <div class="row">
                                <div class="col-lg-12">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="show-bank-photo">
                                        <img src="" class="bank-photo" width="100%" alt="">
                                    </div>
                                    <br />
                                    <div class="btn btn-danger btn-delete-bank-photo" style="display: ">Delete bank photo</div>
                                    <div class="btn-add-bank-photo">
                                        <input type="file" name="file_bank">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

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
</script>
