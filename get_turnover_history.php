<?php
include("common/dbcon.php");
include("models/PromotionModel.php");
$id = '';
$html = '';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {
    $query = "SELECT * FROM member_account WHERE member_id='$id' AND turnover > 0 ORDER BY trans_date DESC ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
//    foreach ($result as $row) {
//       array_push($data,['id'=>$row['id'],'display_name'=>$row['display_name'],'username'=>$row['username'],'status'=>$row['status'],'use_start'=>$row['use_start'],'use_end'=>$row['use_end'],
//           'branch_price'=>$row['branch_price'],'is_dash'=>$row['is_dashboard'],'is_prod'=>$row['is_product']
//           ,'is_return'=>$row['is_return'],'is_history'=>$row['is_history'],'is_customer'=>$row['is_customer']
//           ,'is_tool'=>$row['is_tool'],'is_user'=>$row['is_user'],'is_all'=>$row['is_all']]);
//    }
    foreach ($result as $row) {
       $html.='<tr>';
        $html.='<td>'.date("d/m/Y H:i:s",strtotime($row['trans_date'])).'</td>';
        $html.='<td>'.number_format($row['turnover']).'</td>';
        $html.='</tr>';
    }

    echo $html;
}else{
    echo $html;
}


?>
