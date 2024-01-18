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
        <link rel="stylesheet" href="css/signup.css"/>
        <style>
            body{
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

                $teachersql = mysqli_query($connection, "INSERT INTO `teacher`(`t_fname`, `t_lname`, `position`, `grade`, `section`, `p_id`) VALUES ('" . $_POST['fname'] . "','" . $_POST['lname'] . "','" . $_POST['position'] . "','" . $_POST['grade'] . "','" . $_POST['section'] . "',1)");
                $t_id = mysqli_insert_id($connection);
                $loginsql = mysqli_query($connection, "INSERT INTO `login`(`email`, `pass`, `t_id`) VALUES ('" . $_POST['email'] . "','" . $_POST['pass'] . "',$t_id)");
                $_SESSION["t_id"] = $t_id;
                echo '<script>alert("Signed up successfully");</script>';
                echo '<script>window.location.replace("profile.php");</script>';
                exit();
            }
        }
        ?>
    </body>
    <div>
        <h1>Phyll Up Form</h1>
        <form method="POST">
            <input type="text" name="fname" placeholder="First Name" required>
            <input type="text" name="lname" placeholder="Surname" required>
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="pass" placeholder="Password" required>
            <input type="password" name="pass2" placeholder="Confirm Password" required>
            <input type="text" name="position" placeholder="Teaching Position" required>
            <section>
                <label>Handling PE Grade:</label>
                <select name='grade' required>
                    <option value="Four">Four</option>
                    <option value="Five">Five</option>
                    <option value="Six">Six</option>
                </select>
            </section>
            <input type="text" name="section" placeholder="Section" required>
            <input type="submit" name="signup" value="SIGN UP">
        </form>
    </div>
</body>
</html>
