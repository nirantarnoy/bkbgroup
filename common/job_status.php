<?php
function loopcheck($data,$findid){
    for($i=0;$i<=count($data)-1;$i++){
        if($findid == $data[$i]['id']){
            return $data[$i]['name'];
        }
    }
}
function loopcheckid($data,$findname){
    for($i=0;$i<=count($data)-1;$i++){
        if($findname == $data[$i]['name']){
            return $data[$i]['id'];
        }
    }
}
function showJobstatus(){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>1,'name'=>'Started.'],
        ['id'=>2,'name'=>'Finished.']

    ];
    return $data;
}
function getJobStatusId($id){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>1,'name'=>'Started.'],
        ['id'=>2,'name'=>'Finished.']
    ];
    $name = '';
    if($id > 0 ){
        $name = loopcheck($data,$id);
    }
    return $name;
}
function getJobStatusName($name){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>1,'name'=>'Started.'],
        ['id'=>2,'name'=>'Finished.']
    ];
    $id = '';
    if($name != ''){
        $id = loopcheckid($data,$name);
    }
    return $id;

}
function showYesNo(){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>1,'name'=>'No'],
        ['id'=>2,'name'=>'Yes'],

    ];
    return $data;
}
?>
