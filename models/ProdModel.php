<?php
function getProdmodel($code ,$connect){
    $query = "SELECT * FROM product WHERE prod_code='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['model'];
        }
    }
}
?>
