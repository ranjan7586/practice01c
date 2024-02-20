<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="index.js"></script>
    <link rel="stylesheet" href="./css/index.css">
    <title>User Details</title>
</head>

<body>
    <div class="new" align="right">
        <a href="resgistration.html" target="_blank" class="add_new">Add New User</a>
    </div>


    <div class="heading">
        <h1>User Monitoring Panel</h1>
    </div>
    <div class="search_sec">
        <input type="text" name="search" id="search">
        <button id="search_btn">Search</button>
    </div>
    <div class="container">
        <table border="1">
            <thead>
                <th><input type="checkbox" name="select_all" id="select_all">
                    <label for="select_all"></label>
                </th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone No.</th>
                <th>Email</th>
                <th>password</th>
                <th>Image</th>
                <th>Gender</th>
                <th>Language Known</th>
                <th>Country</th>
                <th>Action</th>
            </thead>
            <tbody>
                <!-- <tr>
                    <td><input type="checkbox" name="select" class="raw_check"></td>
                    <td>Ranjan Jana</td>
                    <td>7586905449</td>
                    <td>ranjanjana012@gmail.com</td>
                    <td><img width="50px" height="50px"
                            src="https://i.pinimg.com/564x/96/86/5a/96865a867e81e62649beb2f9e7351923.jpg" alt=""></td>
                    <td>Male</td>
                    <td>Hindi,English,Bengali</td>
                    <td>India</td>
                    <td>
                        <button>Edit</button>
                        <button class="delete_btn">Delete</button>
                        <button class="view_btn">View</button>

                    </td>
                </tr> -->
                <tr>
                    <td><input type="checkbox" name="select" class="raw_check"></td>
                    <td><?php
                        print $_GET["firstname"]; ?></td>
                    <td><?php
                        print $_GET["lastname"]; ?></td>
                    <td><?php
                        print $_GET["phone_number"]; ?></td>
                    <td><?php
                        print $_GET["email"]; ?></td>
                    <td><?php
                        print $_GET["password"]; ?></td>

                    <td><img width="50px" height="50px" src="<?php
                                                                print $image = $_GET["image"]; ?>" alt=""></td>
                    <td><?php
                        print $_GET["gender"]; ?></td>
                    <td><?php foreach ($_GET["language"] as $item) {
                            print $item.",";
                        } ?></td>
                    <td><?php
                        print $_GET["country"]; ?></td>
                    <td>
                        <button>Edit</button>
                        <button class="delete_btn">Delete</button>
                        <button class="view_btn">View</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="view_sec">
        <table class="view_table" border="1">
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
                <td id="ph_no"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td id="email"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td id="password"></td>
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

</body>

</html>