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
    if (!empty($_SESSION["t_id"])) {
        header("Location: list.php");
    } else {
        if (isset($_POST['login'])) {
            $sqlogin = mysqli_query($connection, "SELECT * FROM `login` WHERE `email`='" . $_POST['email'] . "' AND `pass` = '" . $_POST['pass'] . "'");
            while ($row = mysqli_fetch_assoc($sqlogin)) {
                if ($_POST['email'] === $row['email'] && $_POST['pass'] === $row['pass']) {
                    $_SESSION["t_id"] = $row["t_id"];
                    echo '<script>alert("Logged in successfully");</script>';
                    echo '<script>window.location.replace("list.php");</script>';
                    exit();
                }
            }
        }
    }
    ?>
</body>

<main>
    <form method="POST">
        <div class="logo">
            <img src="assets/wlogo.png">
            <h1>PhyStats</h1>
        </div>

        <center>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="pass" placeholder="Password" required><br>

            <input type="submit" name="login" value="Log In">

            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </center>
    </form>
</main>

</body>

</html>