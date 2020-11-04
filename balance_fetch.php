<?php
session_start();
include("common/dbcon.php");
include("models/PromotionModel.php");
include("models/BankModel.php");
include("models/UserModel.php");

$id = '';
$html = '';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {
    $query = "SELECT * FROM bank_account_company WHERE id='$id'";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $html.='<tr>';
        $html.='<td>'.$row['name'].'</td>';
        $html.='<td>'.$row['bank_account'].'</td>';
        $html.='<td>'.getBankname($connect,$row['bank_id']).'</td>';
        $html.='<td>'.number_format($row['balance']).'</td>';
        $html.='</tr>';
    }

    echo $html;
}else{
    echo $html;
}


?>
