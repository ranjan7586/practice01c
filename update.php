<?php {
    $localhost = "10.10.10.12";
    $username = "root";
    $password = "c0relynx";
    $dbname = "registration";
    $conn = mysqli_connect($localhost, $username, $password, $dbname);
    if (!$conn) {
        die("error" . mysqli_connect_error());
    } else
        echo "connection successfull";
}



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
        print_r($row);
        if ($row['phone'] == $phone) {
            echo "<script>
        let c=5;
        c=alert('Phone Number already exists');
        if(c==undefined){
            history.back();
        }
        </script>";
            exit;
        } else if ($row['email'] == $email) {
            echo "<script>
        let c=5;
        c=alert('Email already exists');
        if(c==undefined){
            history.back();
        }
        </script>";
            exit;
        }
    }
}

    $sqlImage = "SELECT `image`,`firstname`,`lastname`,`email`,`phone` FROM `reg02` WHERE `id`='$id';";
    $resultImage = mysqli_query($conn, $sqlImage);
    if ($resultImage) {
        $row = mysqli_fetch_assoc($resultImage);
    }
    print_r($row);
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
        echo $withoutext;

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
    echo "<script>
    let c=5;
    c=alert('Updation Successful');
    if(c==undefined){
        window.location.href='backendfetch.php';
    }
    </script>";
} else {
    echo "error" . $conn->error;
}

$conn->close();
