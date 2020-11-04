<?php
function createlogs($connect,$userid,$log_type,$menu,$member_name){
   if($userid && $log_type != '' && $menu !=''){
       $t_date = date('Y-m-d H:i:s');
       $sql = "INSERT INTO trans_logs (menu_name,user_id,action_type,trans_date,member_name) VALUES('$menu','$userid','$log_type','$t_date','$member_name')";
       if ($result = $connect->query($sql)) {
           return true;
       }else{
           return false;
       }
   }else{
       return false;
   }
}

?>
