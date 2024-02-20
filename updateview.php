<?php
$servername = "10.10.10.12";
$username = "root";
$password = "c0relynx";
$dbname = "registration";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("error" . mysqli_connect_error());
} else {
    echo "<script>console.log('database connected')</script>";
}
if (isset($_GET["mode"]) && isset($_GET["id"])) {
    $mode = $_GET['mode'];
    $id = $_GET['id'];
    // echo $id;
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
    // print_r($langArr);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="resgistration.css">
    <title>User Registration</title>
</head>

<body>
    <div class="back" align="left">
    </div>
    <div class="container">
        <form action="update.php" method="POST" name="formOne" id="formOne" enctype="multipart/form-data">
            <table id="reg_table" class="table">
                <tr>
                    <td colspan="2" id="heading">
                        <h1> User Registration Form
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td>First Name :</td>
                    <td><input type="text" name="firstname" id="firstname" value="<?php echo $row['firstname']; ?>"></td>
                </tr>
                <tr>
                    <td>Last Name :</td>
                    <td><input type="text" name="lastname" id="lastname" value="<?php echo $row['lastname']; ?>"></td>
                </tr>
                <tr>
                    <td>Phone Number :</td>
                    <td><input type="number" name="phone_number" id="phone_number" maxlength="10" value="<?php echo $row['phone']; ?>"></td>
                </tr>
                <tr>
                    <td>Email :</td>
                    <td><input type="email" name="email" id="email" value="<?php echo $row['email']; ?>"></td>
                </tr>
                <tr>
                    <td>Password :</td>
                    <td><input type="password" name="password" id="password" value="<?php echo $row['password']; ?>"></td>
                </tr>
                <tr>
                    <td>Confirm Your Password :</td>
                    <td><input type="password" name="cpassword" id="cpassword" value="<?php echo $row['password']; ?>"></td>
                </tr>
                <tr>
                    <td>Date of birth :</td>
                    <td><input name="dateofbirth" id="date" value="<?php echo $row['dob']; ?>"><i class="fa-solid fa-calendar-days"></i></td>
                </tr>
                <tr>
                    <td>Gender :</td>
                    <td>
                        <label for="male">Male</label>
                        <input type="radio" name="gender" id="male" value="Male" class="gender" <?php echo($row['gender'] == 'male') ? "checked" : "" ?>>

                        <label for="female">Female</label>
                        <input type="radio" name="gender" id="female" value="Female" class="gender" <?php echo($row['gender'] == 'female') ? "checked" : "" ?> >
                    </td>
                    <!-- <td></td> -->
                </tr>
                <tr>
                    <td>Language Known :</td>
                    <td>
                        <input class="language" type="checkbox" name="language[]" value="hindi" id="hindi"  <?php echo(in_array('hindi',$langArr))? "checked" : "" ?> >
                        <label for="hindi">Hindi</label>

                        <input class="language" type="checkbox" name="language[]" value="english" id="english" <?php echo(in_array('english',$langArr))? "checked" : "" ?> >
                        <label for="english">English</label>

                        <input class="language" type="checkbox" name="language[]" value="bengali" id="bengali" <?php echo(in_array('bengali',$langArr))? "checked" : "" ?> >
                        <label for="bengali">Bengali</label>
                    </td>
                </tr>
                <tr>
                    <td>Select your Country :</td>
                    <td>
                        <select name="country" id="country"  >
                            <option selected disabled value="">Select Country</option>
                            <option value="india" <?php echo ($row['country']=='india')?'selected':''; ?> >India</option>
                            <option value="australia" <?php echo ($row['country']=='australia')?'selected':''; ?> >Australia</option>
                            <option value="england" <?php echo ($row['country']=='england')?'selected':''; ?> >England</option>
                            <option value="nepal" <?php echo ($row['country']=='nepal')?'selected':''; ?> >Nepal</option>
                            <option value="france" <?php echo ($row['country']=='france')?'selected':''; ?> >France</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Upload Your Image :</td>
                    <td><input onchange="handleImage()" type="file" name="newImage" id="newImage" value="<?php echo $row['image']; ?>" ></td>
                </tr>
                <tr class='img_prev'>
                    <td>Preview</td>
                    <td> <img width="50" height="50" src="<?php echo "uploads/".str_replace(" ","",(strtolower($row['firstname']).strtolower($row['lastname']).$row['email']."/".$row['image'])); ?>" alt="">  </td>
                </tr>

                <tr >
                    <td>Write Something About Yourself :</td>
                    <td><textarea name="about_user" id="about_user" cols="30" rows="5"  ><?php echo $row['about']; ?></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" id="submit_btn">
                        <!-- <input id="submit" type="submit" value="submit"> -->
                        <input id="update" type="submit" value="update" data-id="<?php echo $id; ?>">
                        <input id="reset" type="reset" value="reset">
                        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                    </td>
                </tr>

            </table>
        </form>
    </div>

</body>
<script src="update.js"></script>
<!-- <script>
    function handleImage(){
        console.log("hi");
        $('.img_prev').hide();
        
    }
</script> -->

</html>