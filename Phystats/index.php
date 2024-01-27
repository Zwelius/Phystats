<?php
session_start();
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phystats - Login</title>
    <link rel="stylesheet" href="css/login.css" />
    <style>
        body {
            background-image: url("assets/bgg.png");
            background-position: center;
            background-size: cover;
        }
    </style>
</head>

<body>
    <?php
    include 'config.php';

    $failedToLogin = '';

    if (!empty($_SESSION["teacher_ID"])) {
        header("Location: list.php");
    } else if (!empty($_SESSION["principal_ID"])) {
        header("Location: dashboard.php");
    } else {
        if (isset($_POST['login'])) {
            $sqlogin = mysqli_query($connection, "SELECT * FROM `principal_tb` WHERE `principal_EMAIL` = '" . $_POST['email'] . "' AND `principal_PASSWORD` = '" . $_POST['pass'] . "'");
            $count = mysqli_num_rows($sqlogin);
            $row = mysqli_fetch_assoc($sqlogin);
            if ($count == 1) {
                if ($_POST['email'] === $row['principal_EMAIL'] && $_POST['pass'] === $row['principal_PASSWORD']) {
                    $_SESSION["principal_ID"] = $row["principal_ID"];
                    echo '<script>alert("Logged in successfully");</script>';
                    echo '<script>window.location.replace("dashboard.php");</script>';
                    exit();
                } else {
                    $failedToLogin = "User not found. Please check your credentials.";
                }
            } else if ($count == 0) {
                $sqlogin = mysqli_query($connection, "SELECT * FROM `teacher_tb`");
                while ($row = mysqli_fetch_assoc($sqlogin)) {
                    if ($_POST['email'] === $row['teacher_EMAIL'] && $_POST['pass'] === $row['teacher_PASSWORD']) {
                        $_SESSION["teacher_ID"] = $row["teacher_ID"];
                        echo '<script>alert("Logged in successfully");</script>';
                        echo '<script>window.location.replace("list.php");</script>';
                        exit();
                    } else {
                        $failedToLogin = "User not found. Please check your credentials.";
                    }
                }
            } else {
                $failedToLogin = "User not found. Please check your credentials.";
            }
        }
    }
    ?>
    <main>
        <form method="POST">
            <div class="logo">
                <img src="assets/wlogo.png">
                <h1>PhyStats</h1>
            </div>

            <center>
                <!---->
                <?php if (!empty($failedToLogin)): ?>
                    <div style="background-color: #facec1; color: red; border-radius: 5px; font-weight: bold">
                        <?php echo $failedToLogin; ?>
                    </div>
                <?php endif; ?>

                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="pass" placeholder="Password" required><br>

                <input type="submit" name="login" value="Log In">

                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </center>
        </form>
    </main>

</body>

</html>