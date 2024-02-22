<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/registration.js"></script>
    <link rel="stylesheet" href="css/resgistration.css">
    <title>User Registration</title>
</head>

<body>
    <div id="warning">
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
                    <td><input name="dateofbirth" id="date" ><i class="fa-solid fa-calendar-days"></i></td>
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
                    <td><input type="file" name="image" id="image" ></td>
                </tr>

                <tr>
                    <td>Write Something About Yourself :</td>
                    <td><textarea name="about_user" id="about_user" cols="30" rows="5"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" id="submit_btn"><input id="submit" type="submit" value="submit">
                        <input id="reset" type="reset" value="reset">
                    </td>
                    </tr>

            </table>
        </form>
    </div>

</body>


</html>