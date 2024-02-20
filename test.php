<?php 
if($_GET['mode'] && $_GET['data']){
    $data=json_decode($_GET['data'],true);
    $str=$data["searchstr"];
    echo $str;
    // print_r($data);
    // echo "<br>".$data->fromDate;
    // var_dump($data->fromDate);
}
?>