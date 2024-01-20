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
    <title>Phystats - Profile</title>
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/profile.css" />
</head>

<body>
    <?php
    include 'config.php';
    if (empty($_SESSION["t_id"])) {
        header("Location: index.php");
    } else {
        $t_id = $_SESSION["t_id"];

        $viewsql = mysqli_query($connection, "SELECT * FROM `login` WHERE `t_id`='$t_id'");
        while ($rowlogin = mysqli_fetch_assoc($viewsql)) {
            $email = $rowlogin['email'];
            $pass = $rowlogin['pass'];
        }
        $viewsql2 = mysqli_query($connection, "SELECT * FROM `teacher` INNER JOIN `gradesection` ON gradesection.t_id = teacher.t_id WHERE teacher.t_id='" . $_SESSION["t_id"] . "'");
        while ($rowteach = mysqli_fetch_assoc($viewsql2)) {
            $fname = $rowteach['t_fname'];
            $lname = $rowteach['t_lname'];
            $position = $rowteach['position'];
            $grade = $rowteach['grade'];
            $section = $rowteach['section'];
        }

        if (isset($_POST['update'])) {
            $updatelogsql = mysqli_query($connection, "UPDATE `login` `email`='" . $_POST['email'] . "', `pass`='" . $_POST['pass'] . "' WHERE `t_id`='" . $_SESSION["t_id"] . "'");
            $updateprofsql = mysqli_query($connection, "UPDATE `teacher` SET `t_fname`='" . $_POST['fname'] . "',`t_lname`='" . $_POST['lname'] . "',`position`='" . $_POST['position'] . "' WHERE `t_id`='" . $_SESSION["t_id"] . "'");
            $updategradesql = mysqli_query($connection, "UPDATE `gradesection` SET `grade`='" . $_POST['grade'] . "',`section`='" . $_POST['section'] . "' WHERE `t_id`='" . $_SESSION["t_id"] . "'");
            echo '<script>alert("Updated successfully");window.location.replace("profile.php");</script>';
        } else if (isset($_POST['logout'])) {
            unset($_SESSION["t_id"]);
            echo '<script>alert("Logged out successfully");window.location.replace("index.php");</script>';
            exit();
        }
    }
    ?>
    <nav>
        <div>
            <img class="logo" src="assets/wlogo.png">
            <h1 class="title">Phystats</h1>
        </div>
        <div>
            <a href="list.php" class="nav-options">STUDENT LIST</a>
            <a href="result.php" class="nav-options">TEST RESULTS</a>
            <a href="profile.php" class="here nav-options"><img class="profile" src="assets/wprof.png"></a>
        </div>
    </nav>

    <section>
        <form class="prof" method="POST">
            <div>
                <h1>Profile</h1>
                <center>
                    <input type="text" name="fname" placeholder="First Name" value="<?php echo $fname ?>" required>
                    <input type="text" name="lname" placeholder="Surname" value="<?php echo $lname ?>" required>
                    <input type="text" name="position" placeholder="Teaching Position" value="<?php echo $position ?>"
                        required>
                    <div>
                        <label>Handling PE Grade:</label>
                        <select name='grade' required>
                            <option value="Four" <?php if (isset($grade) && $grade === "four")
                                echo 'selected'; ?>>Four
                            </option>
                            <option value="Five" <?php if (isset($grade) && $grade === "five")
                                echo 'selected'; ?>>Five
                            </option>
                            <option value="Six" <?php if (isset($grade) && $grade === "six")
                                echo 'selected'; ?>>Six
                            </option>
                        </select>
                    </div>
                    <input type="text" name="section" placeholder="Section" value="<?php echo $section ?>" required>
                    <input type="submit" name="update" value="Save Changes">
                </center>
            </div>
            <div>
                <br><br><br><br><br>
                <center>
                    <p>Change Email & Password</p>
                    <input type="text" name="email" placeholder="Email" value="<?php echo $email ?>" required>
                    <input type="password" name="pass" placeholder="Password" value="<?php echo $pass ?>" required>
                    <input class="logout" type="submit" name="logout" value="Logout" formnovalidate>
                </center>
            </div>
        </form </section>
</body>

</html>