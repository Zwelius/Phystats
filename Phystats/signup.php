<?php
session_start();
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phystats - Sign Up</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.ico">
    <link rel="stylesheet" href="css/signup.css" />
    <style>
        body {
            background-image: url("assets/bgg.png");
            background-position: center;
            background-size: cover;
        }
    </style>
</head>

<body style="background-image: url('assets/bgg.png');">
    <?php
    include 'config.php';
    if (isset($_POST['signup'])) {
        $teachername = mysqli_query($connection, "SELECT * FROM `teacher_tb` WHERE `teacher_FNAME` = '" . $_POST['fname'] . "' AND `teacher_LNAME` = '" . $_POST['lname'] . "'");
        if ($teachername && mysqli_num_rows($teachername) > 0) {
            echo '<script>alert("Teacher account already exists. Please go see the admin if there are problems.");</script>';
        } else {
            $login = mysqli_query($connection, "SELECT * FROM `teacher_tb` WHERE `teacher_EMAIL` = '" . $_POST['email'] . "'");
            if ($login && mysqli_num_rows($login) > 0) {
                echo '<script>alert("This email is already in use. Please go see the admin if there are problems.");</script>';
            } else {
                $gradesection = mysqli_query($connection, "SELECT * FROM `gradesection_tb` WHERE `grade` = '" . $_POST['grade'] . "' AND `section` = '" . $_POST['section'] . "'");
                if ($gradesection && mysqli_num_rows($gradesection) > 0) {
                    echo '<script>alert("Grade and Section already assigned to a teacher. Please go see the admin if there are problems.");</script>';
                } else {
                    if ($_POST['pass'] === $_POST['pass2']) {

                        $teachersql = mysqli_query($connection, "INSERT INTO `teacher_tb`(`teacher_FNAME`, `teacher_LNAME`, `teacher_EMAIL`, `teacher_PASSWORD`, `principal_ID`, `status`) VALUES ('" . $_POST['fname'] . "','" . $_POST['lname'] . "','" . $_POST['email'] . "','" . $_POST['pass'] . "',1, 'Archive')");
                        $teacher_ID = mysqli_insert_id($connection);
                        $gradesql = mysqli_query($connection, "INSERT INTO `gradesection_tb`(`grade`, `section`, `teacher_ID`) VALUES ('" . $_POST['grade'] . "','" . $_POST['section'] . "','$teacher_ID')");
                        $_SESSION["teacher_ID"] = $teacher_ID;
                        echo '<script>alert("Signed up successfully please check with your Admin to verify account");</script>';
                        echo '<script>window.location.replace("index.php");</script>';
                        exit();
                    }
                }
            }
        }
    }
    ?>


    <main>
        <form method="POST">
            <span>Phyll Up Form</span>
            <div class="container">
                <div class="left">
                    <label>FIRST NAME</label><br>
                    <input type="text" name="fname" class="label" required><br>
                    <label>SURNAME</label><br>
                    <input type="text" name="lname" class="label" required><br>
                    <div class="handling-pe-grade-and-section-container">
                        <div class="handling-pe-grade">
                            <label>HANDLING PE GRADE</label><br>
                            <select name='grade' required>
                                <option value="Four">Four</option>
                                <option value="Five">Five</option>
                                <option value="Six">Six</option>
                            </select>
                        </div>
                        <div class="section">
                            <label>SECTION</label><br>
                            <input type="text" name="section" class="custom-width" required>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <label>EMAIL</label><br>
                    <input type="text" name="email" required><br>
                    <label>PASSWORD</label><br>
                    <input type="password" name="pass" required><br>
                    <label>CONFIRM PASSWORD</label><br>
                    <input type="password" name="pass2" required>
                </div>
            </div>
            <center>
                <input type="submit" name="signup" value="Sign Up"><br>
                <p>Already have an account? <a href="index.php">Log in</a></p>
            </center>
        </form>
    </main>
</body>

</html>