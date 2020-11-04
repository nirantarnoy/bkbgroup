<?php

function transInUpdate($connect, $bank_id , $amount){
    if($bank_id && $amount > 0){
        $bank_balance =0;
        $sql = "SELECT balance FROM bank_account_company WHERE id='$bank_id'";
        $statement = $connect->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if($filtered_rows > 0){

            foreach($result as $row){
                $bank_balance = $row['balance'];
            }
        }

        $new_balance = $amount + $bank_balance;

        $sql2 = "UPDATE bank_account_company SET balance = '$new_balance' WHERE id ='$bank_id'";
        if ($result2 = $connect->query($sql2)) {
          return 1;
        }else{
            return 0;
        }


    }else{
        return 0;
    }
}

function transOutUpdate($connect, $bank_id , $amount){
    if($bank_id && $amount > 0){
        $bank_balance =0;
        $sql = "SELECT balance FROM bank_account_company WHERE id='$bank_id'";
        $statement = $connect->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if($filtered_rows > 0){

            foreach($result as $row){
                $bank_balance = $row['balance'];
            }
        }

        $new_balance = $bank_balance - $amount;

        $sql2 = "UPDATE bank_account_company SET balance = '$new_balance' WHERE id ='$bank_id'";
        if ($result2 = $connect->query($sql2)) {
            return 1;
        }else{
            return 0;
        }


    }else{
        return 0;
    }
}

?>
