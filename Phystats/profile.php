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
    if (empty($_SESSION["id"])) {
        header("Location: index.php");
    } else {
        $t_id = $_SESSION["id"];

        $viewsql = mysqli_query($connection, "SELECT * FROM `login` WHERE `t_id`='$t_id'");
        while ($rowlogin = mysqli_fetch_assoc($viewsql)) {
            $email = $rowlogin['email'];
            $pass = $rowlogin['pass'];
        }
        $viewsql2 = mysqli_query($connection, "SELECT * FROM `teacher` INNER JOIN `gradesection` ON gradesection.t_id = teacher.t_id WHERE teacher.t_id='" . $_SESSION["id"] . "'");
        while ($rowteach = mysqli_fetch_assoc($viewsql2)) {
            $fname = $rowteach['t_fname'];
            $lname = $rowteach['t_lname'];
            $position = $rowteach['position'];
            $grade = $rowteach['grade'];
            $section = $rowteach['section'];
        }

        if (isset($_POST['update'])) {
            $updatelogsql = mysqli_query($connection, "UPDATE `login` SET `email`='" . $_POST['email'] . "', `pass`='" . $_POST['pass'] . "' WHERE `t_id`='" . $_SESSION["id"] . "'");
            $updateprofsql = mysqli_query($connection, "UPDATE `teacher` SET `t_fname`='" . $_POST['fname'] . "',`t_lname`='" . $_POST['lname'] . "',`position`='" . $_POST['position'] . "' WHERE `t_id`='" . $_SESSION["id"] . "'");
            $updategradesql = mysqli_query($connection, "UPDATE `gradesection` SET `grade`='" . $_POST['grade'] . "',`section`='" . $_POST['section'] . "' WHERE `t_id`='" . $_SESSION["id"] . "'");
            echo '<script>alert("Updated successfully");window.location.replace("profile.php");</script>';
        } else if (isset($_POST['logout'])) {
            unset($_SESSION["id"]);
            echo '<script>window.location.replace("index.php");</script>';
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

    <main>
        <form method="POST">
            <section>
                <div class="left">
                    <p><span class="account-settings">Account Settings</span><br>
                        <span class="page-description">Manage your profile</span>
                    </p>
                    <div class="personal-details">
                        <a href="profile.php">
                            <div class="selected-option">Personal Details</div>
                        </a>
                    </div>

                    <div class="selection-container">
                        <input type="submit" name="logout" value="Logout" formnovalidate
                            onclick="return confirm('Are you sure you want to logout?')">
                    </div>
                </div>

                <div class="right">
                    <span>Personal Details</span>
                    <hr>
                    <main>
                        <div class="personal-details-left">
                            <label>FIRST NAME</label><br>
                            <input type="text" name="fname" value="<?php echo $fname ?>" required><br>
                            <label>SURNAME</label><br>
                            <input type="text" name="lname" value="<?php echo $lname ?>" required><br>
                            <div class="position-and-handling-pe-grade">
                                <div class="position">
                                    <label>POSITION</label><br>
                                    <input type="text" name="position" value="<?php echo $position ?>" required><br>
                                </div>
                                <div>
                                    <label>HANDLING PE GRADE</label><br>
                                    <select name='grade' required>
                                        <option value="Four" <?php if (isset($grade) && $grade === "Four") {
                                            echo 'selected';
                                        } ?>>Four</option>
                                        <option value="Five" <?php if (isset($grade) && $grade === "Five") {
                                            echo 'selected';
                                        } ?>>Five</option>
                                        <option value="Six" <?php if (isset($grade) && $grade === "Six") {
                                            echo 'selected';
                                        } ?>>Six</option>
                                    </select>
                                </div>
                            </div>
                            <label>SECTION</label><br>
                            <input type="text" name="section" value="<?php echo $section ?>" required><br><br>
                            <input type="submit" name="update" value="Save Changes"
                                onclick="return confirm('You are about to do some changes. Do you want to proceed?')">
                        </div>

                        <div class="personal-details-right">
                            <label>CHANGE EMAIL & PASSWORD</label><br>
                            <input type="text" name="email" placeholder="Email" value="<?php echo $email ?>" required>
                            <input type="password" name="pass" placeholder="Password" value="<?php echo $pass ?>"
                                required><br>
                        </div>
                    </main>
                </div>
            </section>
        </form>
    </main>
</body>

</html>