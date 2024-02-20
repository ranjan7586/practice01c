<?php
   $localhost = "10.10.10.12";
   $username = "root";
   $password = "c0relynx";
   $dbname = "registration";
   $conn = mysqli_connect($localhost, $username, $password, $dbname);
   if (!$conn) {
       die("error" . mysqli_connect_error());
   } else
       echo "connection successfull";


if($_GET['mode'] && $_GET['searchstring']){
    $searchstr = $_GET['searchstring'];
    $sql="select * from `reg02` where `deleted`='0' and (`firstname` like '%$searchstr%' or `lastname` like '%$searchstr%' or `email` like '%$searchstr%');
    ";
    $result = mysqli_query($conn, $sql);
    

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="index.js"></script>
    <title>User Details</title>
</head>


<body>
    <div class="heading">
        <h1>User Monitoring Panel</h1>
    </div>
    <div class="search_sec">
        <input type="text" name="search" id="search">
        <button id="search_btn" class="search_btn btn btn-secondary">Search</button>
    </div>
    <div class="delete_all_sec container mb-3 d-flex justify-content-between">
        <button class="delete_all_btn btn btn-danger">Delete</button>
        <button onclick="addNew()" class="add_new btn btn-info">Add new user</button>
    </div>
    <div class="view_sec">
        <table class="view_table table-bordered" border="1">
            <tr>
                <td>Firstname</td>
                <td id="firstname"></td>
            </tr>
            <tr>
                <td>Lastname</td>
                <td id="lastname"></td>
            </tr>
            <tr>
                <td>Phone No</td>
                <td id="phone"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td id="email"></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td id="gender"> </td>
            </tr>
            <tr>
                <td>Language Known</td>
                <td id="language"></td>
            <tr>
                <td>Country</td>
                <td id="country"></td>
            </tr>
            <tr>
                <td class="view_td" colspan="2"><button class="view_cancel">Cancel</button></td>
            </tr>
        </table>
    </div>
    <?php

    echo '<div class="container">
<table border="1" class="table table-hover">
<thead>
<tr>
<th><input type="checkbox" name="select_all" id="select_all">
                <label for="select_all"></label>
            </th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone No.</th>
            <th>Email</th>
            <th>Image</th>
            <th>Gender</th>
            <th>Language Known</th>
            <th>Country</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $imglength = strlen($row['image']);
            $imgdotindex = strrpos($row['image'], '.');
            $imgsubstr = substr($row['image'], 0, $imgdotindex);
            $dataId = $row['id'];
            // echo $imgsubstr."<br>";
            echo '<tr>
                <td><input type="checkbox" name="select" class="raw_check" value="' . $row["id"] . '"></td>
                <td>' . $row["firstname"] . '</td>
                <td>' . $row["lastname"] . '</td>
                <td>' . $row["phone"] . '</td>
                <td>' . $row["email"] . '</td>

                <td><img width="50px" height="50px" src="' . 'uploads/' . $imgsubstr . "/" . $row['image'] . '" alt=""></td>
                <td>' . $row["gender"] . '</td>
                <td>' . $row["language"] . '</td>
                <td>' . $row["country"] . '</td>
                <td>
                <button class="view_btn btn btn-success" data-id=' . $dataId . '>View</button>
                    <button class="edit_btn btn btn-primary" data-id=' . $dataId . ' >Edit</button>
                    <button class="delete_btn btn btn-danger" data-id=' . $dataId . '>Delete</button>
                </td>
            </tr>
        ';
        }
        echo '</tbody> </table> </div> ';
    } else {
        echo "<tr>
                <td colspan='10'>No records found</td>
                </tr>";
    }
    $conn->close();

    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function addNew() {
        window.location.href = 'resgistration.php';
    }
</script>

</html>