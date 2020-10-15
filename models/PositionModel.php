<?php
function getPositionmodel($connect){
    $data = [];
    $query = "SELECT * FROM position_user";
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
function getPositionname($connect,$code){
    $query = "SELECT * FROM position_user WHERE id='$code'";
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

function checkPer($pos_id,$menu,$connect){
    $query = "SELECT * FROM position_user WHERE id='$pos_id' AND ".$menu.">0";
    $statement = $connect->prepare($query);
    $statement->execute();
    // $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        return true;
    }else{
        return false;
    }

    //return false;
}

function checkInitper($pos_id,$connect){
    $init_per = '';
    $query = "SELECT * FROM position_user WHERE id='$pos_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            if($row['is_member'] == 1){
                $init_per = 'member';
            }
            if($row['is_accounting'] == 1){
                $init_per = 'memberaccounting';
            }
            if($row['is_promotion'] == 1){
                $init_per = 'promotion';
            }
            if($row['is_capital'] == 1){
                $init_per = 'capital';
            }
            if($row['is_bank'] == 1){
                $init_per = 'bank';
            }
            if($row['is_user'] == 1){
                $init_per = 'user';
            }
            if($row['is_position'] == 1){
                $init_per = 'position';
            }
            if($row['is_all'] == 1){
                $init_per = 'member';
            }
        }
    }

    return $init_per;
}
?>
