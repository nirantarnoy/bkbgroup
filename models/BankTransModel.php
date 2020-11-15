<?php
date_default_timezone_set('Asia/Bangkok');

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
    if($bank_id && $amount != ''){
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

        $new_balance = $bank_balance - abs($amount);

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

function createtrans($connect , $bank_id, $activity_name, $trans_type, $amt ,$user){
    if($bank_id >0 && $activity_name !='' && $trans_type > 0 && $user > 0 ){
         $t_amt = $amt;
         if($trans_type == 2){
             if($amt > 0){
                 $t_amt = ($amt * -1);
             }
         };

         $t_date = date('Y-m-d H:m:i');

         $sql = "INSERT INTO bank_trans(trans_date,bank_id,activity,trans_type,amount,user_id) VALUES ('$t_date','$bank_id','$activity_name','$trans_type','$t_amt','$user')";

         if ($result = $connect->query($sql)) {
             if($trans_type ==1){
                 transInUpdate($connect, $bank_id, $amt);
             }else if($trans_type == 2){
                 transOutUpdate($connect, $bank_id, $t_amt);
             }
            return 1;
        }else{
            return 0;
        }
    }
}


?>
