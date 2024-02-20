
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
            echo "<script>
            let c=5;
            c=alert('Email already exists');
            if(c==undefined){
                history.back();
            }
            </script>";
            exit;
        } else if ($row['phone'] == $phone) {
            echo "<script>
            let c=5;
            c=alert('Phone Number already exists');
            if(c==undefined){
                history.back();
            }
            </script>";
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
            // echo "success";
            echo "<script>
        let c=5;
        c=alert('Registration Successful');
        if(c==undefined){
            window.location.href='backendfetch.php';
        }
        </script>";
            // header('Location:backendfetch.php');
        } else {
            echo "error" . $conn->error;
        }
    }
    ?>