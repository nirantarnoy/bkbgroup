<?php
ob_start();
session_start();

if(!isset($_SESSION['userid'])){
   // header("location:loginpage.php");
}
include("common/dbcon.php");
$query_filter = '';
$query = "SELECT * FROM capital WHERE id > 0 ";

if(isset($_POST["searchByText"])){
    $query .= ' AND (list LIKE "%'.$_POST["searchByText"].'%"';
    $query .= 'OR price LIKE "%'.$_POST["searchByText"].'%") ';
}
if(isset($_POST["searchByCurrency"])){
    if($_POST["searchByCurrency"] > 0){
        $query .= ' AND currency_id ='.$_POST["searchByCurrency"];
    }

}
if(isset($_POST["searchByFromdate"]) && isset($_POST["searchByTodate"])){
    if($_POST["searchByFromdate"] != null && $_POST["searchByTodate"] != null){
        $from_date = explode('/',$_POST["searchByFromdate"]);
        $to_date = explode('/',$_POST["searchByTodate"]);
        $f_date = '';
        $t_date = '';
//        if(count($from_date)>1){
//            $f_date = $from_date[1].'/'.$from_date[0].'/'.$from_date[2];
//        }
//        if(count($to_date)>1){
//            $t_date = $to_date[1].'/'.$to_date[0].'/'.$to_date[2];
//        }
//        $f_date = date('Y-m-d H:m:i',strtotime($f_date));
//        $t_date = date('Y-m-d H:m:i',strtotime($t_date));
        $f_date = date('Y-m-d H:m:i', strtotime($_POST["searchByFromdate"]));
        $t_date = date('Y-m-d H:m:i',strtotime($_POST["searchByTodate"]));
        $query .= ' AND (trans_date >= "'.$f_date.'" AND trans_date <="'.$t_date.'")';
    }

}
//if(isset($_POST["searchByFromdate"]) && isset($_POST["searchByTodate"])){
//    if($_POST["searchByFromdate"] != null && $_POST["searchByTodate"] != null){
//        $query .= ' AND (trans_date >="'.date('Y-m-d',strtotime($_POST["searchByFromdate"])).'"';
//        $query .= ' AND trans_date <="'.date('Y-m-d',strtotime($_POST["searchByTodate"])).'")';
//    }
//
//}

//if(isset($_POST["type_name"])){
//    $query .= 'proj_type LIKE "%'.$_POST["type_name"].'%" AND ';
//}
//if(isset($_POST["university_name"])){
//    $query .= 'dept_name LIKE "%'.$_POST["university_name"].'%" AND ';
//}
//if(isset($_POST["search"]["value"]))
//{
//    $query .= '(list LIKE "%'.$_POST["search"]["value"].'%"';
//    $query .= 'OR price LIKE "%'.$_POST["search"]["value"].'%") ';
//}
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

    //$branch_name = $row['branch'];
    $sub_array = array();
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['trans_date'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.date('Y-m-d',strtotime($row['expend_date'])).'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['list'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: right">'.number_format($row['qty']).'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: right">'.number_format($row['price']).'</p>';
    $sub_array[] = number_format($row['total']);
  //  $sub_array[] = '<p style="font-weight: ;text-align: right" class="line-total">'.number_format($row['total']).'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['cashier_name'].'</p>';
    $sub_array[] = '<div class="btn btn-secondary" data-id="'.$row['id'].'" onclick="showupdate($(this))"><i class="fas fa-edit"></i> Edit</div><span> </span><div class="btn btn-danger" data-id="'.$row['id'].'" data-var="'.$row['total'].'" onclick="recDelete($(this))"><i class="fas fa-trash-alt"></i> Delete</div>';

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
