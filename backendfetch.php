<?php
$servername = "10.10.10.12";
$username = "root";
$password = "c0relynx";
$dbname = "registration";
$targetpath = "uploads/";
$conn = new mysqli($servername, $username, $password, $dbname);
if (!$conn) {
    die("connection failed" . mysqli_connect_error());
} else {
    echo "<script>console.log('Database connected')</script>";
}
$flag = 0;
if ($_GET['mode'] && $_GET['data']) {
    $data = json_decode($_GET['data'],true);
    // print_r($data);
    $searchstr = $data["searchstr"];
    $fromdate = $data['fromDate'];
    $todate=$data['toDate'];
    $filterdate = $data['filterDate'];
    if($todate=="" && !$filterdate){
        $todate=date("Y-m-d");
    }
    if($fromdate=="" && !$filterdate){
        $fromdate=date("1990-01-01");
    }
    if($todate){
        $newtodate=date("Y-m-d", strtotime($data['toDate']."+1 day"));
    }
    $todaydate = date("Y-m-d");
    $yesterdaydate = date("Y-m-d", strtotime("-1 days"));
    $last7daysdate = date("Y-m-d", strtotime("-7 days"));
    $where = "";

  
    if($filterdate && $fromdate && $todate){
        $filterdate=null;
    }

    if ($searchstr != "") {
        $where .= "and (`firstname` like '%$searchstr%' or `lastname` like '%$searchstr%' or `phone` like '%$searchstr%' or `email` like '%$searchstr%' or `gender` like '%$searchstr%' or `country` like '%$searchstr%' or `language` like '%$searchstr%')";
    }
  
    if (($fromdate!="") && ($todate!="")) {
        // echo "enters";
        $where .= "and `created_date`>='$fromdate' and `created_date`<='$newtodate'";
    }
    if ($filterdate != "" && ($filterdate == 'today')) {
        $where .= "and `created_date` like '%$todaydate%'";
    }
    if ($filterdate != "" && ($filterdate == 'yesterday')) {
        $where .= "and `created_date` like '%$yesterdaydate%'";
    }
    if ($filterdate != "" && ($filterdate == 'last7days')) {
        $where .= "and `created_date`<'$todaydate' and `created_date`>='$last7daysdate'";
    }
    
    echo "<script>console.log('$where')</script>";
    $sql = "select * from `reg02` where `deleted`='0' $where";
    // echo $sql."<br";
    // echo $searchstr."kiol";


    $result = mysqli_query($conn, $sql);
    global $flag;
    $flag = 1;
} else {

    $sql = "SELECT * FROM `reg02` where deleted='0'";
    $result = $conn->query($sql);
    // print_r($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="index.css">
    <script src="index.js"></script>
    <title>User Details</title>
</head>


<body>
    <div class="heading">
        <h1>User Monitoring Panel</h1>
    </div>
    <div class="search_sec">
        <input type="text" name="search" id="search">
        <button id="search_btn" class="search_btn btn btn-warning"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    <div class="filters container">
    <label for="fromdate">From</label>
        <input name="fromdate" id="fromdate" class="date m-2 form-control" style="width:auto;">
        <label for="todate">To</label>
        <input name="todate" id="todate" class="date m-2 form-control" style="width:auto;">
        <select name="filterdate" id="filterdate" class="form-control" style="width:auto;" >
            <option value="" disabled selected>Previous</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="last7days">Last 7 days</option>
        </select>
    </div>
    <div id="filter_view" class="container"></div>
    <div class="delete_new">
        <div class="delete_all_sec container mb-3 d-flex justify-content-between">
            <button class="delete_all_btn btn btn-danger">Delete</button>
            <?php if ($flag == 1) {
                echo '<button class="all_record_btn btn btn-warning">All Records</button>';
            } ?>
            <button onclick="addNew()" class="add_new btn btn-info">Add new user</button>
        </div>
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
                <td class="view_td" colspan="2"><button class="view_cancel btn btn-danger">Cancel</button></td>
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
                <td colspan='10' class='no_record'>No records found</td>
                </tr>";
    }
    echo "<script>
    let viewSec=document.getElementById('#filter_view');
    viewSec.innerHTML+='hi';
    viewSec.innerHTML+='$fromdate';
    viewSec.innerHTML+='$viewdate';
    viewSec.innerHTML+='$filterdate';
        console.log('hi789');
        </script>";
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