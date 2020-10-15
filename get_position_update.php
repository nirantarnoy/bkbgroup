<?php
include("common/dbcon.php");
$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {
    $query = "SELECT * FROM position_user WHERE id='$id' ";
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
        array_push($data,[
            'id'=>$row['id'],
            'name'=>$row['name'],
            'description'=>$row['description'],
            'is_member'=>$row['is_member'],
            'is_member'=>$row['is_member'],
            'is_accounting'=>$row['is_accounting'],
            'is_promotion'=>$row['is_promotion'],
            'is_capital'=>$row['is_capital'],
            'is_bank'=>$row['is_bank'],
            'is_user'=>$row['is_user'],
            'is_position'=>$row['is_position'],
            'is_all'=>$row['is_all'],

        ]);
    }

    echo json_encode($data);
}else{
    echo json_encode($data);
}


?>
