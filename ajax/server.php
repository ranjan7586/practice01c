<?php
$servername = "10.10.10.12";
$username = "root";
$password = "c0relynx";
$dbname = "registration";
$conn = new mysqli($servername, $username, $password, $dbname);
if (!$conn) {
    die("connection failed" . mysqli_connect_error());
}


//view all data

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['mode']) && ($_POST['mode'] == 'view')) {

        $targetpath = "uploads/";
        $flag = 0;
        {

            $sql = "SELECT * FROM `reg02` where deleted='0'";
            $result = $conn->query($sql);
            // print_r($result);
        }


        $viewcontent = '<div>
    <div class="heading">
        <h1>User Monitoring Panel</h1>
    </div>
    <div class="search_sec">
        <input type="text" name="search" id="search" placeholder="Type here to search ...">
        <button id="search_btn" class="search_btn btn btn-warning"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    <div class="filters container">
    <label for="fromdate">From</label>
        <input name="fromdate" id="fromdate" class="date m-2 form-control" placeholder="Select date" style="width:auto;">
        <label for="todate">To</label>
        <input name="todate" id="todate" class="date m-2 form-control"  placeholder="Select date" style="width:auto;">
        <select name="filterdate" id="filterdate" class="form-control"  style="width:auto;" >
            <option value="" disabled selected>Previous</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="last7days">Last 7 days</option>
        </select>
    </div>
    <div id="filter_view" class="container"></div>
    <div class="delete_new">
        <div class="delete_all_sec container mb-3 d-flex justify-content-between">
            <button class="delete_all_btn btn btn-danger" onClick="deleteSelected()" >Delete</button>
            <button  class="add_new btn btn-info" onClick="addNewUser()">Add new user</button>
        </div>
    </div>
<div class="container">
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
                $viewcontent .= '<tr>
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
                <button class="view_btn btn btn-success" onClick=viewData(' . $dataId . ')>View</button>
                    <button class="edit_btn btn btn-primary" onclick=updateUser(' . $dataId . ')>Edit</button>
                    <button class="delete_btn btn btn-danger" onClick=deleteData(' . $dataId . ')>Delete</button>
                </td>
            </tr>
        ';
            }
        } else {
            $viewcontent .= "<tr>
                <td colspan='10' class='no_record'>No records found</td>
                </tr>";
        }
        $viewcontent .= '</tbody> </table> </div> ';
        echo $viewcontent;
    }
}

//delete single item via button

if (isset($_POST["mode"]) && $_POST["mode"] == "delete") {
    if (isset($_POST["dataId"])) {
        $id = $_POST['dataId'];
        $sql = "UPDATE `reg02` SET `deleted` = '1' WHERE `reg02`.`id` = $id";
        $conn->query($sql);
    }
}


//view details of a row or data
if (isset($_POST["mode"]) && $_POST["mode"] == "viewspecific") {
    if (isset($_POST["dataId"])) {
        $id = $_POST['dataId'];
        $sql = "select * from `reg02` where `reg02`.`id` = $id";
        $result = $conn->query($sql);
        if( $result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        $content=' <div class="view_sec_inner">
        <table class="view_table table-bordered" border="1">
            <tr>
                <td>Firstname</td>
                <td id="firstname">'.$row['firstname'].'</td>
            </tr>
            <tr>
                <td>Lastname</td>
                <td id="lastname">'.$row['lastname'].'</td>
            </tr>
            <tr>
                <td>Phone No</td>
                <td id="phone">'.$row['phone'].'</td>
            </tr>
            <tr>
                <td>Email</td>
                <td id="email">'.$row['email'].'</td>
            </tr>
            <tr>
                <td>Gender</td>
                <td id="gender"> '.$row['gender'].'</td>
            </tr>
            <tr>
                <td>Language Known</td>
                <td id="language">'.$row['language'].'</td>
            <tr>
                <td>Country</td>
                <td id="country">'.$row['country'].'</td>
            </tr>
            <tr>
                <td class="view_td" colspan="2"><button class="view_cancel btn btn-danger" onClick="viewCancel()">Cancel</button></td>
            </tr>
        </table>
    </div>';
    echo $content;
    }
}


//delete selected items
if(isset($_POST["mode"]) && $_POST["mode"] == "deleteselect"){
    $data=$_POST['data'];
    foreach ($data as $id) {
        $sql="UPDATE `reg02` SET `deleted` = '1' WHERE `reg02`.`id` = '$id';";
        $conn->query($sql);
    }
    echo "success";
}


//search item
if (isset($_POST["operation"]) && $_POST["operation"] == "search") {
        $olddata=$_POST['allData'];
        $data = json_decode($olddata,true);
        $searchstr = $data["searchstr"];
        $fromdate = $data['fromDate'];
        $todate = $data['toDate'];
        $filterdate = $data['filterDate'];
        if ($todate == "" && !$filterdate) {
            $todate = date("Y-m-d");
        }
        if ($fromdate == "" && !$filterdate) {
            $fromdate = date("1990-01-01");
        }
        if ($todate) {
            $newtodate = date("Y-m-d", strtotime($data['toDate'] . "+1 day"));
        }
        $todaydate = date("Y-m-d");
        $yesterdaydate = date("Y-m-d", strtotime("-1 days"));
        $last7daysdate = date("Y-m-d", strtotime("-7 days"));
        $where = "";

        if ($filterdate && $fromdate && $todate) {
            $filterdate = null;
        }

        if ($searchstr != "") {
            $where .= "and (`firstname` like '%$searchstr%' or `lastname` like '%$searchstr%' or `phone` like '%$searchstr%' or `email` like '%$searchstr%' or `gender` like '%$searchstr%' or `country` like '%$searchstr%' or `language` like '%$searchstr%')";
        }

        if (($fromdate != "") && ($todate != "")) {
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

        $sql = "select * from `reg02` where `deleted`='0' $where";

        $result = mysqli_query($conn, $sql);
        global $flag;
        $flag = 1;
        $viewcontent = '<div>
    <div class="heading">
        <h1>User Monitoring Panel</h1>
    </div>
    <div class="search_sec">
        <input type="text" name="search" id="search" placeholder="Type here to search ...">
        <button id="search_btn" class="search_btn btn btn-warning"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    <div class="filters container">
    <label for="fromdate">From</label>
        <input name="fromdate" id="fromdate" class="date m-2 form-control" placeholder="Select date" style="width:auto;">
        <label for="todate">To</label>
        <input name="todate" id="todate" class="date m-2 form-control"  placeholder="Select date" style="width:auto;">
        <select name="filterdate" id="filterdate" class="form-control"  style="width:auto;" >
            <option value="" disabled selected>Previous</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="last7days">Last 7 days</option>
        </select>
    </div>
    <div id="filter_view" class="container"></div>
    <div class="delete_new">
        <div class="delete_all_sec container mb-3 d-flex justify-content-between">
            <button class="delete_all_btn btn btn-danger" onClick="deleteSelected()">Delete</button>
                <button class="all_record_btn btn btn-warning" onClick="viewAllRecords()">All Records</button>
            <button  class="add_new btn btn-info" onClick="addNewUser()">Add new user</button>
        </div>
    </div>
<div class="container">
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
                $viewcontent .= '<tr>
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
                <button class="view_btn btn btn-success" onClick=viewData(' . $dataId . ')>View</button>
                    <button class="edit_btn btn btn-primary" onclick=updateUser(' . $dataId . ')>Edit</button>
                    <button class="delete_btn btn btn-danger" onClick=deleteData(' . $dataId . ')>Delete</button>
                </td>
            </tr>
        ';
            }
        } else {
            $viewcontent .= "<tr>
                <td colspan='10' class='no_record'>No records found</td>
                </tr>";
        }
        $viewcontent .= '</tbody> </table> </div> ';
        echo $viewcontent;
       
    } 


//add new user
if(isset($_POST['mode']) && $_POST["mode"]=='createnewuser'){
    $content='
    <div class="main_content_reg">
        <div id="cancel">
            <button class="btn btn-danger" onclick="cancelAdd()">Cancel</button>
        </div>
        <div class="container">
            <form name="formOne" id="formOne" enctype="multipart/form-data">
                <table id="reg_table" class="table_1">
                    <tr>
                        <td colspan="2" id="heading">
                            <h1> User Registration Form
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td>First Name :</td>
                        <td><input type="text" name="firstname" id="firstname"></td>
                    </tr>
                    <tr>
                        <td>Last Name :</td>
                        <td><input type="text" name="lastname" id="lastname"></td>
                    </tr>
                    <tr>
                        <td>Phone Number :</td>
                        <td><input type="number" name="phone_number" id="phone_number" maxlength="10"></td>
                    </tr>
                    <tr>
                        <td>Email :</td>
                        <td><input type="email" name="email" id="email"></td>
                    </tr>
                    <tr>
                        <td>Password :</td>
                        <td><input type="password" name="password" id="password"></td>
                    </tr>
                    <tr>
                        <td>Confirm Your Password :</td>
                        <td><input type="password" name="cpassword" id="cpassword"></td>
                    </tr>
                    <tr>
                        <td>Date of birth :</td>
                        <td><input name="dateofbirth" id="date"><i class="fa-solid fa-calendar-days"></i></td>
                    </tr>
                    <tr>
                        <td>Gender :</td>
                        <td>
                            <label for="male">Male</label>
                            <input type="radio" name="gender" id="male" value="Male" class="gender">

                            <label for="female">Female</label>
                            <input type="radio" name="gender" id="female" value="Female" class="gender">

                        </td>
                        <!-- <td></td> -->
                    </tr>
                    <tr>
                        <td>Language Known :</td>
                        <td>
                            <input class="language" type="checkbox" name="language[]" value="hindi" id="hindi">
                            <label for="hindi">Hindi</label>

                            <input class="language" type="checkbox" name="language[]" value="english" id="english">
                            <label for="english">English</label>

                            <input class="language" type="checkbox" name="language[]" value="bengali" id="bengali">
                            <label for="bengali">Bengali</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Select your Country :</td>
                        <td>
                            <select name="country" id="country">
                                <option selected disabled value="">Select Country</option>
                                <option value="india">India</option>
                                <option value="australia">Australia</option>
                                <option value="england">England</option>
                                <option value="nepal">Nepal</option>
                                <option value="france">France</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Upload Your Image :</td>
                        <td><input type="file" name="image" id="image"></td>
                    </tr>

                    <tr>
                        <td>Write Something About Yourself :</td>
                        <td><textarea name="about_user" id="about_user" cols="30" rows="5"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" id="submit_btn"><input id="submit" type="submit" value="submit" >
                            <input id="reset" type="reset" value="reset">
                        </td>
                    </tr>

                </table>
            </form>
        </div>
        
    </div>'; 


   echo $content;
}



//update new user
if(isset($_POST['mode']) && $_POST["mode"]=='updateuser'){
    $id=$_POST['data'];
    
    $sql = "SELECT * FROM reg02 WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_array($result);
        // print_r($row);
    } else {
        echo "error";
    }
    $img=$row['image'];

    $langArr=explode(",", $row['language']);

    $content='<div class="main_update_content">
    <div id="cancel">
    <button class="btn btn-danger" onclick="cancelAdd()">Cancel</button>
</div>
    <div class="container">
        <form name="formOne" id="formOne" enctype="multipart/form-data">
            <table id="reg_table" class="table_1">
                <tr>
                    <td colspan="2" id="heading">
                        <h1> User Details Updation Form
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td>First Name :</td>
                    <td><input type="text" name="firstname" id="firstname" value="'.$row['firstname'].'"></td>
                </tr>
                <tr>
                    <td>Last Name :</td>
                    <td><input type="text" name="lastname" id="lastname" value="'.$row['lastname'].'"></td>
                </tr>
                <tr>
                    <td>Phone Number :</td>
                    <td><input type="number" name="phone_number" id="phone_number" maxlength="10" value="'.$row['phone'].'"></td>
                </tr>
                <tr>
                    <td>Email :</td>
                    <td><input type="email" name="email" id="email" value="'.$row['email'].'"></td>
                </tr>
                <tr>
                    <td>Password :</td>
                    <td><input type="password" name="password" id="password" value="'.$row['password'].'"></td>
                </tr>
                <tr>
                    <td>Confirm Your Password :</td>
                    <td><input type="password" name="cpassword" id="cpassword" value="'.$row['password'].'"></td>
                </tr>
                <tr>
                    <td>Date of birth :</td>
                    <td><input name="dateofbirth" id="date" value="'.$row['dob'].'"><i class="fa-solid fa-calendar-days"></i></td>
                </tr>
                <tr>
                    <td>Gender :</td>
                    <td>
                        <label for="male">Male</label>
                        <input type="radio" name="gender" id="male" value="Male" class="gender" '.($row['gender'] == 'male' ? "checked" : "") .'>

                        <label for="female">Female</label>
                        <input type="radio" name="gender" id="female" value="Female" class="gender" '.($row['gender'] == 'female' ? "checked" : "") .' >
                    </td>
                    <!-- <td></td> -->
                </tr>
                <tr>
                    <td>Language Known :</td>
                    <td>
                        <input class="language" type="checkbox" name="language[]" value="hindi" id="hindi"  '.(in_array('hindi',$langArr)? "checked" : "" ).' >
                        <label for="hindi">Hindi</label>

                        <input class="language" type="checkbox" name="language[]" value="english" id="english" '.(in_array('english',$langArr)? "checked" : "") .' >
                        <label for="english">English</label>

                        <input class="language" type="checkbox" name="language[]" value="bengali" id="bengali" '.(in_array('bengali',$langArr)? "checked" : "") .' >
                        <label for="bengali">Bengali</label>
                    </td>
                </tr>
                <tr>
                    <td>Select your Country :</td>
                    <td>
                        <select name="country" id="country"  >
                            <option selected disabled value="">Select Country</option>
                            <option value="india" '.($row['country']=='india'?"selected":"").' >India</option>
                            <option value="australia" '.($row['country']=='australia'?'selected':'').' >Australia</option>
                            <option value="england" '.($row['country']=='england'?'selected':'').' >England</option>
                            <option value="nepal" '.($row['country']=='nepal'?'selected':'').' >Nepal</option>
                            <option value="france" '.($row['country']=='france'?'selected':'').' >France</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Upload Your Image :</td>
                    <td><input onchange="handleImage()" type="file" name="newImage" id="newImage" value="'.$row['image'].'" ></td>
                </tr>
                <tr class="img_prev">
                    <td>Preview</td>
                    <td> <img width="50" height="50" src="'."uploads/".str_replace(" ","",(strtolower($row['firstname']).strtolower($row['lastname']).$row['email']."/".$row['image'])).'" alt="">  </td>
                </tr>

                <tr >
                    <td>Write Something About Yourself :</td>
                    <td><textarea name="about_user" id="about_user" cols="30" rows="5"  >'.$row['about'].'</textarea></td>
                </tr>
                <tr>
                    <td colspan="2" id="submit_btn">
                        <!-- <input id="submit" type="submit" value="submit"> -->
                        <input id="update" type="submit" value="update" data-id="'.$id.'">
                        <input id="reset" type="reset" value="reset">
                        <input type="hidden" name="id" value="'.$row['id'].'">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>';


   echo $content;
}




//create new record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['mode'] == 'createrecord') {
        $name = $_POST["name"];
        $mode = $_POST["mode"]; { {
                $localhost = "10.10.10.12";
                $username = "root";
                $password = "c0relynx";
                $dbname = "registration";
                $conn = mysqli_connect($localhost, $username, $password, $dbname);
                if (!$conn) {
                    die("error" . mysqli_connect_error());
                }
            }

            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $phone = $_POST["phone_number"];
            $email = $_POST["email"];
            $password = md5($_POST["password"]);
            $cpassword = md5($_POST["cpassword"]);
            $dob = $_POST["dateofbirth"];
            $gender = strtolower($_POST["gender"]);
            $country = $_POST["country"];
            $language = $_POST["language"];
            $date = $_POST['date'];
            // $image=$_POST["image"];
            $about = $_POST["about_user"];

            $sql = "select * from `reg02` where `email` = '$email' or `phone`='$phone'";
            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_array($result);
                if ($row['email'] == $email) {
                    echo "'Email already exists'";
                    exit;
                } else if ($row['phone'] == $phone) {
                    echo "'Phone Number already exists'";
                    exit;
                }
            } else {
                // echo "hi";
                $lang = "";
                foreach ($language as $item) {
                    $lang .= $item . ",";
                }
                $newdirname = $firstname . " " . $lastname . " " . $email;
                $filelocation = strtolower(trim($newdirname)) . "/";
                $fileupdatedlocation = str_replace(" ", "", $filelocation);
                $createfile = mkdir("uploads/" . $fileupdatedlocation);
                echo $filelocation;
                if (isset($_FILES['image'])) {
                    $filename = basename($_FILES['image']['name']);

                    $extension = pathinfo($filename, PATHINFO_EXTENSION);

                    $imgnamedatabase = str_replace(" ", "", strtolower(trim($newdirname)) . "." . $extension);


                    $filetempname = $_FILES['image']['tmp_name'];
                    print_r($_FILES);
                    $target_path = "uploads/" . $fileupdatedlocation . $imgnamedatabase;
                    echo "kii", $target_path;
                    $newfilepath = $target_path;
                    // echo $newfilepath.$$extension;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                        echo "File uploaded successfully!";
                    } else {
                        echo "Sorry, file not uploaded, please try again!";
                    }
                }


                $creator = "Ranjan";
                $modifier = "Ranjan";

                $sql = "INSERT INTO `reg02` (`firstname`, `lastname`, `phone`, `email`, `password`, `dob`, `gender`, `language`, `country`, `image`, `about`,`created_by`, `modified_by`) VALUES ('$firstname', '$lastname', '$phone', '$email', '$password', '$dob', '$gender', '$lang', '$country', '$imgnamedatabase', '$about','$creator', '$modifier');";

                if ($result = $conn->query($sql)) {
                    echo "<script>
                    alert('Registration Successful');
                    </script>";
                    echo "success";
                } else {
                    echo "error" . $conn->error;
                }
            }
        }
    }
}

//update new record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['mode'] == 'update') { 

        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $phone = $_POST["phone_number"];
        $email = strtolower($_POST["email"]);
        $password = md5($_POST["password"]);
        $cpassword = md5($_POST["cpassword"]);
        $dob = $_POST["dateofbirth"];
        $gender = strtolower($_POST["gender"]);
        $country = $_POST["country"];
        $language = $_POST["language"];
        $id = $_POST['id'];



        $sql = "select `phone`,`email` from `reg02` where `deleted`='0' AND `id` != '$id'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if ($row['phone'] == $phone) {
                    echo "
                Phone Number already exists
               ";
                    exit;
                } else if ($row['email'] == $email) {
                    echo "
                'Email already exists'
               
                ";
                    exit;
                }
            }
        }

        $sqlImage = "SELECT `image`,`firstname`,`lastname`,`email`,`phone` FROM `reg02` WHERE `id`='$id';";
        $resultImage = mysqli_query($conn, $sqlImage);
        if ($resultImage) {
            $row = mysqli_fetch_assoc($resultImage);
        }
        $oldfirstname = $row['firstname'];
        $oldlastname = $row['lastname'];
        $oldemail = $row['email'];
        $oldimage = $row['image'];
        $oldphone = $row['phone'];

        $newImageName;
        if ($_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
            $newExtension = pathinfo(basename($_FILES['newImage']['name']), PATHINFO_EXTENSION);
            // echo $newExtension;
            global $newImageName;
            $newImageName = strtolower(str_replace(" ", "", $firstname . $lastname . $email . "." . $newExtension));
            $newImageFileName = strtolower(str_replace(" ", "", $firstname . $lastname . $email));
            $newFolder = 'uploads/' . $newImageFileName;
            if (!file_exists($newFolder)) {
                mkdir(strtolower($newFolder), 0777, true);
                if (($firstname != $oldfirstname) || ($lastname != $oldlastname) || ($email != $oldemail)) {
                    unlink(strtolower("uploads/" . $oldfirstname . $oldlastname . $oldemail) . "/" . $oldimage);
                    rmdir(strtolower("uploads/" . $oldfirstname . $oldlastname . $oldemail));
                }
            } else {
                unlink($newFolder . "/" . $oldimage);
            }

            move_uploaded_file($_FILES['newImage']['tmp_name'], strtolower($newFolder . "/" . $newImageName));
        } else {
            echo "else";
            if (($firstname != $oldfirstname) || ($lastname != $oldlastname) || ($email != $oldemail)) {
                $oldUserFolder = str_replace(" ", "", "uploads/" . $oldfirstname . $oldlastname . $oldemail);
                $newUserFolder = strtolower("uploads/" . str_replace(" ", "", $firstname . $lastname . $email));
                $lastDot = strrpos($oldimage, '.');
                $ext = substr($oldimage, $lastDot, strlen($oldimage));
                $withoutext = substr($oldimage, 0, $lastDot);
                $newImageFileName = strtolower($newUserFolder . "/" . str_replace(" ", "", $firstname . $lastname . $email . $ext));
                if (!file_exists($newUserFolder)) {
                    mkdir($newUserFolder);
                }
                if (copy(strtolower($oldUserFolder . "/" . $oldimage), $newImageFileName) && unlink(strtolower($oldUserFolder . "/" . $oldimage))) {
                    rmdir(strtolower($oldUserFolder));
                    echo 'File renamed successfully.';
                } else {
                    echo 'Error renaming the file.';
                }


                global $newImageName;
                $newImageName = strtolower(str_replace(" ", "", $firstname . $lastname . $email . $ext));
            }
        }

        if ($newImageName == "") {
            $newImageName = $oldimage;
        }

        $about = $_POST["about_user"];
        // echo "hi";
        $lang = "";
        foreach ($language as $item) {
            $lang .= $item . ",";
        }

        $creator = "Ranjan";
        $modifier = "Ranjan";

        $sql = "UPDATE `reg02` SET `firstname` = '$firstname', `lastname` = '$lastname',`phone` = '$phone', `email` = '$email', `password` = '$password', `dob` = '$dob', `gender` = '$gender', `language` = '$lang', `country` = '$country', `image` = '$newImageName', `about` = '$about' WHERE `reg02`.`id` ='$id' ;";

        if ($result = $conn->query($sql)) {
            // echo "success";
            echo "
            alert('Updation Successful')";
        } else {
            echo "error" . $conn->error;
        }
        $conn->close();
    }
}


$conn->close();
?>
