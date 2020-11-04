<?php
function getMembermodel($connect){
    $data = [];
    $query = "SELECT * FROM member";
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
function getMemberDatamodel($connect, $id){
    $data = [];
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['id'],
                'phone'=>$row['phone'],
                'bank_id'=>$row['bank_id'],
                'bank_account'=>$row['bank_account'],
                'id_number'=>$row['id_number'],
                'active_date'=>$row['active_date'],

            ]);
        }
    }

    return $data;
}
function getMemberaccount($connect,$code){
    $query = "SELECT * FROM member WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['account_id'];
        }
    }

}
function getMembername($connect,$code){
    $query = "SELECT * FROM member WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['name'];
        }
    }

}
?>
