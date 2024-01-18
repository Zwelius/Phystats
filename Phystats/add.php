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
        <meta charset="UTF-8">
        <title>Phystats - Add Students</title>
        <link rel="stylesheet" href="css/nav.css"/>
        <link rel="stylesheet" href="css/add.css"/>
    </head>
    <body>
        <?php
        include 'config.php';
        if (empty($_SESSION["t_id"])) {
            header("Location: index.php");
        } else {
            $t_id = $_SESSION["t_id"];
            $syears = mysqli_query($connection, "SELECT * FROM `schoolyear` ORDER BY `year` DESC");
            $quarter = mysqli_query($connection, "SELECT * FROM `quarter`");
            $testtype = mysqli_query($connection, "SELECT * FROM `test`");
            if (isset($_POST['cancel'])) {
                header("Location: list.php");
            } else if (isset($_POST['save'])) {
                $query = mysqli_query($connection, "SELECT * FROM `testdate` WHERE `sy_id`='" . $_POST['syear'] . "' AND (`q_id`='" . $_POST['quarter'] . "' AND (`testID`='" . $_POST['testtype'] . "' AND `t_id`='$t_id'))");
                if ($query && mysqli_num_rows($query) < 1) {
                    mysqli_query($connection, "INSERT INTO `testdate` (`sy_id`, `q_id`, `testID`, `t_id`) VALUES ('" . $_POST['syear'] . "','" . $_POST['quarter'] . "','" . $_POST['testtype'] . "','$t_id')");
                    $tdID = mysqli_insert_id($connection);
                } else {
                    $row = mysqli_fetch_assoc($query);
                    $tdID = $row['tdID'];
                }
                $temp = $_POST['weight'] / ($_POST['height'] ** 2);
                $bmi = number_format((float) $temp, 2, '.', '');
                mysqli_query($connection, "INSERT INTO `student` (`tdID`, `name`, `birthdate`, `height`, `weight`, `sex`, `age`, `BMI`, `nutritional status`, `heightforage`) VALUES ('$tdID','" . $_POST['name'] . "','" . $_POST['bday'] . "','" . $_POST['height'] . "','" . $_POST['weight'] . "','" . $_POST['sex'] . "','" . $_POST['age'] . "','$bmi','" . $_POST['nutritionalstatus'] . "','" . $_POST['heightforage'] . "')");
                $s_id = mysqli_insert_id($connection);
                mysqli_query($connection, "INSERT INTO `testresult`(`s_id`, `tdID`, `HRbefore`, `HRafter`, `pushupsNo`, `plankTime`, `zipperRight`, `zipperLeft`, `SaR1`, `SaR2`, `juggling`, `hexagonClockwise`, `hexagonCounter`, `sprintTime`, `SLJ1`, `SLJ2`, `storkRight`, `storkLeft`, `stick1`, `stick2`, `stick3`) VALUES ('$s_id','$tdID','" . $_POST['HRbefore'] . "','" . $_POST['HRafter'] . "','" . $_POST['pushups'] . "','" . $_POST['plank'] . "','" . $_POST['zipperR'] . "','" . $_POST['zipperL'] . "','" . $_POST['sar1'] . "','" . $_POST['sar2'] . "','" . $_POST['juggling'] . "','" . $_POST['hexclock'] . "','" . $_POST['hexcounter'] . "','" . $_POST['sprinttime'] . "','" . $_POST['slj1'] . "','" . $_POST['slj2'] . "','" . $_POST['storkright'] . "','" . $_POST['storkleft'] . "','" . $_POST['stick1'] . "','" . $_POST['stick2'] . "','" . $_POST['stick3'] . "')");
                echo '<script>alert("Added data successfully");</script>';
            }
        }
        ?>
        <nav>
            <div>
                <img class="logo" src="assets/wlogo.png">
                <h1 class="title">Phystats</h1>
            </div>
            <div>
                <a class="here" href="list.php">Student List</a>
                <a href="result.php">Test Results</a>
                <a href="profile.php"><img class="profile" src="assets/wprof.png"></a>
            </div>
        </nav>
        <div class="addform">
            <form method="POST">
                <h1>Physical Fitness Test</h1>

                <select name="syear">
                    <?php
                    while ($row1 = mysqli_fetch_array($syears)) {
                        echo "<option value='" . $row1['sy_id'] . "'>" . $row1['year'] . "</option>";
                    }
                    ?>
                </select>
                <select name="quarter">
                    <?php
                    while ($qtr = mysqli_fetch_array($quarter)) {
                        echo "<option value='" . $qtr['q_id'] . "'>" . $qtr['quarter'] . "</option>";
                    }
                    ?>
                </select>
                <select name="testtype">
                    <?php
                    while ($tt = mysqli_fetch_array($testtype)) {
                        echo "<option value='" . $tt['testID'] . "'>" . $tt['testtype'] . "</option>";
                    }
                    ?>
                </select>

                <label for="name">Name:</label>
                <input type="text" name="name" required>
                <label for="bday">Birth Date:</label>
                <input type="date" name="bday" required>
                <label for="sex">Sex:</label>
                <select name="sex">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <label for="age">Age:</label>
                <input type="number" name="age" required>
                <label for="height">Height(m):</label>
                <input type="number" name="height" step="0.01" required>
                <label for="weight">Weight(kg):</label>
                <input type="number" name="weight" step="0.01" required>
                <label for="nutritionalstatus">Nutritional Status:</label>
                <select name="nutritionalstatus">
                    <option value="Severely Wasted">Severely Wasted</option>
                    <option value="Wasted">Wasted</option>
                    <option value="Normal">Normal</option>
                    <option value="Overweight">Overweight</option>
                    <option value="Obese">Obese</option>
                </select>
                <label for="heightforage">Height-for-Age:</label>
                <select name="heightforage">
                    <option value="Severely Stunted">Severely Stunted</option>
                    <option value="Stunted">Stunted</option>
                    <option value="Normal">Normal</option>
                    <option value="Tall">Tall</option>
                </select>
                <label for="HRbefore">Heart Rate Before Activity(bpm):</label>
                <input type="number" name="HRbefore" step="0.01" required>
                <label for="HRafter">Heart Rate After Activity(bpm):</label>
                <input type="number" name="HRafter" step="0.01" required>
                <label for="pushups">No. of Push Ups:</label>
                <input type="number" name="pushups" required>
                <label for="plank">Basic Plank Time(sec):</label>
                <input type="number" name="plank" required>
                <label for="zipperR">Zipper Test Overlap/Gap Right(cm):</label>
                <input type="number" name="zipperR" step="0.01" required>
                <label for="zipperL">Zipper Test Overlap/Gap Left(cm):</label>
                <input type="number" name="zipperL" step="0.01" required>
                <label for="sar1">Sit and Reach Score 1st Try(cm):</label>
                <input type="number" name="sar1" step="0.01" required>
                <label for="sar2">Sit and Reach Score 2nd Try(cm):</label>
                <input type="number" name="sar2" step="0.01" required>
                <br>
                <label for="juggling">Juggling:</label>
                <input type="number" name="juggling" required>
                <label for="hexclock">Hexagon Agility Test Clockwise Time(sec):</label>
                <input type="number" name="hexclock" required>
                <label for="hexcounter">Hexagon Agility Test Counter Clockwise Time(sec):</label>
                <input type="number" name="hexcounter" required>
                <label for="sprinttime">40-Meter Sprint(min.sec):</label>
                <input type="number" name="sprinttime" step="0.01" required>
                <label for="slj1">Standing Long Jump 1st Trial(cm):</label>
                <input type="number" name="slj1" step="0.01" required>
                <label for="slj2">Standing Long Jump 2nd Trial(cm):</label>
                <input type="number" name="slj2" step="0.01" required>
                <label for="storkright">Stork Balance Stand Test Right Feet(sec):</label>
                <input type="number" name="storkright" required>
                <label for="storkleft">Stork Balance Stand Test Left Feet(sec):</label>
                <input type="number" name="storkleft" required>
                <label for="stick1">Stick Drop Test 1st Trial(cm):</label>
                <input type="number" name="stick1" step="0.01" required>
                <label for="stick2">Stick Drop Test 2nd Trial(cm):</label>
                <input type="number" name="stick2" step="0.01" required>
                <label for="stick3">Stick Drop Test 3rd Trial(cm):</label>
                <input type="number" name="stick3" step="0.01" required><br>
                <input type="submit" name="cancel" value="Cancel" formnovalidate>
                <input type="submit" name="save" value="Save">
            </form>
        </div>
    </body>
</html>