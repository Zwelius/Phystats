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
        if ($_POST['pass'] === $_POST['pass2']) {

            $teachersql = mysqli_query($connection, "INSERT INTO `teacher`(`t_fname`, `t_lname`, `position`, `p_id`) VALUES ('" . $_POST['fname'] . "','" . $_POST['lname'] . "','" . $_POST['position'] . "',1)");
            $t_id = mysqli_insert_id($connection);
            $gradesql = mysqli_query($connection, "INSERT INTO `gradesection`(`t_id`, `grade`, `section`) VALUES ('$t_id','" . $_POST['grade'] . "','" . $_POST['section'] . "')");
            $loginsql = mysqli_query($connection, "INSERT INTO `login`(`email`, `pass`, `t_id`) VALUES ('" . $_POST['email'] . "','" . $_POST['pass'] . "',$t_id)");
            $_SESSION["t_id"] = $t_id;
            echo '<script>alert("Signed up successfully");</script>';
            echo '<script>window.location.replace("profile.php");</script>';
            exit();
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
                    <label>TEACHING METHOD</label><br>
                    <input type="text" name="position" class="label" required><br>
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