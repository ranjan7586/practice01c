<?php 

{
    $localhost="10.10.10.12";
    $username="root";
    $password= "c0relynx";
    $dbname="registration";
    $conn=mysqli_connect($localhost,$username,$password,$dbname);
    if(!$conn){
        die("error".mysqli_connect_error());
    }
    else
    echo "connection successfull";
}   

if(isset($_GET["mode"]) && isset($_GET["dataid"])){
    $mode = $_GET['mode'];
    $dataId=$_GET["dataid"];
    $dataIdArr=explode(",",$dataId);
    print_r($dataIdArr);

    foreach ($dataIdArr as $id) {
        $sql="UPDATE `reg02` SET `deleted` = '1' WHERE `reg02`.`id` = '$id';";
        $conn->query($sql);
    }
    echo "<script>confirm('Items deleted successfully');
    </script>";
    header("Location:backendfetch.php");

}


$conn->close();
?>
