<?php {
    $localhost = "10.10.10.12";
    $username = "root";
    $password = "c0relynx";
    $dbname = "registration";
    $conn = mysqli_connect($localhost, $username, $password, $dbname);
    if (!$conn) {
        die("error" . mysqli_connect_error());
    }
} {
    if (isset($_POST["dataId"])) {
        $id = $_POST['dataId'];
        $sql = "UPDATE `reg02` SET `deleted` = '1' WHERE `reg02`.`id` = $id";
        $conn->query($sql);
        $conn->close();
    }
} {
    if (isset($_POST["viewdataId"]) && isset($_POST['operation'])) {
        $id = $_POST['viewdataId'];
        $sql = "select * from `reg02` where `reg02`.`id` = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(array("error" => ""));
        }
        $conn->close();
    }
}
