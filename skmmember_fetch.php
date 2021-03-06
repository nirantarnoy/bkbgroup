<?php
ob_start();
session_start();

if(!isset($_SESSION['userid'])){
   // header("location:loginpage.php");
}
include("common/dbcon.php");
include("models/BankModel.php");
include("models/PositionModel.php");
include("models/UserModel.php");

$user = 0;
if (isset($_SESSION['userid'])) {
    $user = $_SESSION['userid'];
}

if ($user) {
    $user_position = getUserposition($user,$connect);
}
$is_all = checkIsAdmin($user_position,$connect);

$query_filter = '';
$query = "SELECT * FROM member WHERE member_type ='SKM' ";
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
    $query .= ' AND (name LIKE "%'.$_POST["search"]["value"].'%"';
    $query .= 'OR account_id LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR phone LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR id_number LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR bank_account LIKE "%'.$_POST["search"]["value"].'%") ';
}
if(isset($_POST["order"]))
{
    $query .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= ' ORDER BY id ASC ';
}

$query_filter = $query;

if($_POST["length"] != -1)
{
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$data = array();
$filtered_rows = $statement->rowCount();
foreach ($result as $row){
    $delete_btn = 'none';
    if($is_all){
        $delete_btn = '';
    }
    $islevel = 'No';
    $iscolor = 'red';
    if($row['is_level2'] == 1){
        $islevel='Yes';
        $iscolor='Green';
    }
    //$branch_name = $row['branch'];
    $sub_array = array();
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.date('Y-m-d H:i:s',strtotime($row['active_date'])).'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['account_id'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['name'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['phone'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.getBankname($connect,$row['bank_id']).'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['bank_account'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['id_number'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left;color: '.$iscolor.';">'.$islevel.'</p>';
    $sub_array[] = '<div class="btn btn-secondary" data-id="'.$row['id'].'" onclick="showupdate($(this))"><i class="fas fa-edit"></i> Edit</div><span> </span><div class="btn btn-danger" data-id="'.$row['id'].'" onclick="recDelete($(this))" style="display: '.$delete_btn.'"><i class="fas fa-trash-alt"></i> Delete</div>';

    $data[] = $sub_array;
}
$output = array(
    "draw"				=>	intval($_POST["draw"]),
    "recordsTotal"  	=>  $filtered_rows,
    "recordsFiltered" 	=> 	get_total_all_records($connect,$query_filter),
    "data"    			=> 	$data
);
echo json_encode($output);

function get_total_all_records($connect,$query)
{
    //   $statement = $connect->prepare("SELECT * FROM temp_test");
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}
?>
