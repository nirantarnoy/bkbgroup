<?php
ob_start();
session_start();

if (!isset($_SESSION['userid'])) {
    // header("location:loginpage.php");
}
include("common/dbcon.php");
include("models/BankModel.php");


$query_filter = '';
$query = "SELECT * FROM member WHERE ";
//if(isset($_POST["region_name"])){
//    $query .= 'region_name LIKE "%'.$_POST["region_name"].'%" AND ';
//}
//if(isset($_POST["type_name"])){
//    $query .= 'proj_type LIKE "%'.$_POST["type_name"].'%" AND ';
//}
//if(isset($_POST["university_name"])){
//    $query .= 'dept_name LIKE "%'.$_POST["university_name"].'%" AND ';
//}
if(isset($_POST["search"]["value"]))
{
    $query .= '(name LIKE "%'.$_POST["search"]["value"].'%"';
    $query .= 'OR phone LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR account_id LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR id_number LIKE "%'.$_POST["search"]["value"].'%") ';
}
//if (isset($_POST["searchByText"])) {
//    $query .= '(name LIKE "%' . $_POST["searchByText"] . '%"';
//    $query .= 'OR phone LIKE "%' . $_POST["searchByText"] . '%" ';
//    $query .= 'OR account_id LIKE "%' . $_POST["searchByText"] . '%" ';
//    $query .= 'OR id_number LIKE "%' . $_POST["searchByText"] . '%") ';
//}
//if (isset($_POST["searchByPromotion"]) && $_POST["searchByPromotion"] > 0 ) {
//    $query .= ' AND member_account.promotion_id = ' . $_POST["searchByPromotion"] . '';
//
//}
//if (isset($_POST["searchByFromdate"]) && isset($_POST["searchByTodate"])) {
//    if ($_POST["searchByFromdate"] != null && $_POST["searchByTodate"] != null) {
//        $from_date = explode('/', $_POST["searchByFromdate"]);
//        $to_date = explode('/', $_POST["searchByTodate"]);
//        $f_date = '';
//        $t_date = '';
////        if(count($from_date)>1){
////            $f_date = $from_date[1].'/'.$from_date[0].'/'.$from_date[2];
////        }
////        if(count($to_date)>1){
////            $t_date = $to_date[1].'/'.$to_date[0].'/'.$to_date[2];
////        }
////        $f_date = date('Y-m-d H:m:i',strtotime($f_date));
////        $t_date = date('Y-m-d H:m:i',strtotime($t_date));
//        $f_date = date('Y-m-d H:m:i', strtotime($_POST["searchByFromdate"]));
//        $t_date = date('Y-m-d H:m:i', strtotime($_POST["searchByTodate"]));
//        $query .= ' AND (active_date >= "' . $f_date . '" AND active_date <="' . $t_date . '")';
//    }
//
//}
if (isset($_POST["order"])) {
    $query .= ' ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= ' ORDER BY id ASC ';
}

$query_filter = $query;

if ($_POST["length"] != -1) {
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$data = array();
$filtered_rows = $statement->rowCount();
foreach ($result as $row) {
    $islevel = 'No';
    $iscolor = 'red';
    if ($row['is_level2'] == 1) {
        $islevel = 'Yes';
        $iscolor = 'Green';
    }
    //$branch_name = $row['branch'];
    $sum_net_win = sumnetwin($connect, $row['id']);
    $net_win_color = '';
    if ($sum_net_win < 0) $net_win_color = 'red';

    $sub_array = array();
    $sub_array[] = '<p style="font-weight: ;text-align: left">' . date('d/m/Y H:i:s', strtotime($row['active_date'])) . '</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left"><a data-id="' . $row['id'] . '" href="#" onclick="showmanage($(this))">' . $row['account_id'] . '</a></p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">' . $row['name'] . '</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">' . $row['phone'] . '</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">' . getBankname($connect, $row['bank_id']) . '</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">' . $row['bank_account'] . '</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">' . $row['id_number'] . '</p>';
    $sub_array[] = number_format(sumcashin($connect, $row['id']));
    $sub_array[] = number_format(sumcashout($connect, $row['id']));
    $sub_array[] = number_format($sum_net_win);
//    $sub_array[] = '<p style="font-weight: ;text-align: right;color: ' . $net_win_color . '">' . number_format($sum_net_win) . '</p>';
//    $sub_array[] = '<div class="btn btn-secondary" data-id="'.$row['id'].'" onclick="showupdate($(this))"><i class="fas fa-edit"></i> Edit</div><span> </span><div class="btn btn-danger" data-id="'.$row['id'].'" onclick="recDelete($(this))"><i class="fas fa-trash-alt"></i> Delete</div>';

    $data[] = $sub_array;
}
$output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => get_total_all_records($connect, $query_filter),
    "data" => $data
);
echo json_encode($output);

function get_total_all_records($connect, $query)
{
    //   $statement = $connect->prepare("SELECT * FROM temp_test");
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}

function sumcashin($connect, $member_id)
{
    $qty = 0;
    $query = "SELECT sum(cash_in)as cash_in FROM member_account WHERE member_id='$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    //   $qty = $statement->rowCount();
    foreach ($result as $row) {
        $qty = $row['cash_in'];
    }
    return $qty;
}

function sumcashout($connect, $member_id)
{
    $qty = 0;
    $query = "SELECT sum(cash_out)as cash_out FROM member_account WHERE member_id='$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    //   $qty = $statement->rowCount();
    foreach ($result as $row) {
        $qty = $row['cash_out'];
    }
    return $qty;
}

function sumnetwin($connect, $member_id)
{
    $qty = 0;
    $query = "SELECT sum(net_win)as net_win FROM member_account WHERE member_id='$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    //   $qty = $statement->rowCount();
    foreach ($result as $row) {
        $qty = $row['net_win'];
    }
    return $qty;
}

?>
