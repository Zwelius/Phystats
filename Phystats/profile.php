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
    <link rel="icon" type="image/x-icon" href="assets/logo.ico">
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/profile.css" />
</head>

<body>
    <?php
    include 'config.php';
    if (empty($_SESSION["teacher_ID"])) {
        header("Location: index.php");
    } else {
        $teacher_ID = $_SESSION["teacher_ID"];

        $viewsql = mysqli_query($connection, "SELECT * FROM `teacher_tb` INNER JOIN `gradesection_tb` ON gradesection_tb.teacher_ID = teacher_tb.teacher_ID WHERE teacher_tb.teacher_ID = '$teacher_ID'");
        while ($rowteach = mysqli_fetch_assoc($viewsql)) {
            $fname = $rowteach['teacher_FNAME'];
            $lname = $rowteach['teacher_LNAME'];
            $email = $rowteach['teacher_EMAIL'];
            $pass = $rowteach['teacher_PASSWORD'];
            $grade = $rowteach['grade'];
            $section = $rowteach['section'];
        }

        if (isset($_POST['update'])) {
            $teachername = mysqli_query($connection, "SELECT * FROM `teacher_tb` WHERE `teacher_FNAME` = '" . $_POST['fname'] . "' AND `teacher_LNAME` = '" . $_POST['lname'] . "'");
            if ($teachername && mysqli_num_rows($teachername) > 0) {
                while ($temp = mysqli_fetch_array($teachername)) {
                    $temp_ID = $temp['teacher_ID'];
                }
                if ($temp_ID != $teacher_ID) {
                    echo '<script>alert("Teacher account already exists. Please go see the admin if there are problems.");</script>';
                } else {
                    $login = mysqli_query($connection, "SELECT * FROM `teacher_tb` WHERE `teacher_EMAIL` = '" . $_POST['email'] . "'");
                    if ($login && mysqli_num_rows($login) > 0) {
                        while ($temp = mysqli_fetch_array($login)) {
                            $temp_ID = $temp['teacher_ID'];
                        }
                        if ($temp_ID != $teacher_ID) {
                            echo '<script>alert("This email is already in use. Please go see the admin if there are problems.");</script>';
                        } else {
                            $gradesection = mysqli_query($connection, "SELECT * FROM `gradesection_tb` WHERE `grade` = '" . $_POST['grade'] . "' AND `section` = '" . $_POST['section'] . "'");
                            if ($gradesection && mysqli_num_rows($gradesection) > 0) {
                                while ($temp = mysqli_fetch_array($gradesection)) {
                                    $temp_ID = $temp['teacher_ID'];
                                }
                                if ($temp_ID != $teacher_ID) {
                                    echo '<script>alert("Grade and Section already assigned to a teacher. Please go see the admin if there are problems.");</script>';
                                } else {
                                    $updateprofsql = mysqli_query($connection, "UPDATE `teacher_tb` SET `teacher_FNAME`='" . $_POST['fname'] . "',`teacher_LNAME`='" . $_POST['lname'] . "', `teacher_EMAIL`='" . $_POST['email'] . "', `teacher_PASSWORD`='" . $_POST['pass'] . "' WHERE `teacher_ID`='$teacher_ID'");
                                    $updategradesql = mysqli_query($connection, "UPDATE `gradesection_tb` SET `grade`='" . $_POST['grade'] . "',`section`='" . $_POST['section'] . "' WHERE `teacher_ID`='$teacher_ID'");
                                    echo '<script>alert("Updated successfully");window.location.replace("profile.php");</script>';
                                }
                            }
                        }
                    }
                }
            }
        } else if (isset($_POST['logout'])) {
            unset($_SESSION["teacher_ID"]);
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
                            <div class="handling-pe-grade">
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
                                <div>
                                    <label>SECTION</label><br>
                                    <input type="text" name="section" value="<?php echo $section ?>" required><br><br>

                                </div>
                            </div>
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