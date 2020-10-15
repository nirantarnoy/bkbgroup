<?php
function loopcheckwp($data,$findid){
    for($i=0;$i<=count($data)-1;$i++){
        if($findid == $data[$i]['id']){
            return $data[$i]['name'];
        }
    }
}
function loopcheckwpid($data,$findname){
    for($i=0;$i<=count($data)-1;$i++){
        if($findname == $data[$i]['name']){
            return $data[$i]['id'];
        }
    }
}
function showWPStatus(){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>1,'name'=>'No'],
        ['id'=>2,'name'=>'Yes'],
    ];
    return $data;
}
function getWPStatus($id){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>1,'name'=>'No'],
        ['id'=>2,'name'=>'Yes'],
    ];
    $name = '';
    if($id > 0 ){
        $name = loopcheckwp($data,$id);
    }
    return $name;
}
function getIdByName($name){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>1,'name'=>'No'],
        ['id'=>2,'name'=>'Yes'],
    ];
    $id = '';
    if($name != ''){
        $id = loopcheckwpid($data,$name);
    }
    return $id;
}
?>
