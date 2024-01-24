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

    if (!empty($_SESSION["t_id"])) {
        header("Location: list.php");
    } else {
        if (isset($_POST['login'])) {
            $sqlogin = mysqli_query($connection, "SELECT * FROM `principal` WHERE `email` = '" . $_POST['email'] . "' AND `pass` = '" . $_POST['pass'] . "'");
            $count = mysqli_num_rows($sqlogin);
            $row = mysqli_fetch_assoc($sqlogin);
            if ($count == 1) {
                if ($_POST['email'] === $row['email'] && $_POST['pass'] === $row['pass']) {
                    $_SESSION["p_id"] = $row["p_id"];
                    echo '<script>alert("Logged in successfully");</script>';
                    echo '<script>window.location.replace("dashboard.php");</script>';
                    exit();
                } else {
                    $failedToLogin = "User not found. Please check your credentials.";
                }
            } else if ($count == 0) {
                $sqlogin = mysqli_query($connection, "SELECT * FROM `login`");
                while ($row = mysqli_fetch_assoc($sqlogin)) {
                    if ($_POST['email'] === $row['email'] && $_POST['pass'] === $row['pass']) {
                        $_SESSION["t_id"] = $row["t_id"];
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
                <?php if (!empty($failedToLogin)) : ?>
                    <div style="color: white;">
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