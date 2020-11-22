<?php
ob_start();
session_start();

if (!isset($_SESSION['userid'])) {
    // header("location:loginpage.php");
}
include("common/dbcon.php");
include "models/UserModel.php";
include "models/MemberModel.php";

$id= 0;

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

$query_filter = '';
$query = "SELECT * FROM bank_trans WHERE ";
if(isset($_POST["searchId"])){
    $query .= 'member_id ='.$_POST["searchId"].'';
}
//if(isset($_POST["type_name"])){
//    $query .= 'proj_type LIKE "%'.$_POST["type_name"].'%" AND ';
//}
//if(isset($_POST["university_name"])){
//    $query .= 'dept_name LIKE "%'.$_POST["university_name"].'%" AND ';
//}
if (isset($_POST["search"]["value"])) {
    $query .= ' AND amount LIKE "%' . $_POST["search"]["value"] . '%"';
//    $query .= ' AND (amount LIKE "%' . $_POST["search"]["value"] . '%"';
//    $query .= 'OR bank_id LIKE "%' . $_POST["search"]["value"] . '%") ';
}
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
$i = 0;
$filtered_rows = $statement->rowCount();
foreach ($result as $row) {
    $activity_color = 'green';
    if ($row['trans_type'] == 2) {
        $activity_color = 'red';
    }
    $member_data_id = getMemberidnumber($connect, $row['member_id']);
    $i += 1;
    //$branch_name = $row['branch'];
    $sub_array = array();
    $sub_array[] = '<p style="text-align: center">' . $i . '</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">' . $row['trans_date'] . '</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left;color: ' .$activity_color.'">' . $row['activity'] . '</p>';
    $sub_array[] = $row['amount'];
//    $sub_array[] = $row['amount'];
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

?>
