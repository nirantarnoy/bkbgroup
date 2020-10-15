<?php
function getPromotionmodel($connect){
    $data = [];
    $query = "SELECT * FROM promotion";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['id'],'name'=>$row['name']]);
        }
    }

    return $data;
}
function getPromotionname($connect,$code){
    $name = '';
    $query = "SELECT * FROM promotion WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            $name =  $row['name'];
        }
    }

    return $name;
}
?>
