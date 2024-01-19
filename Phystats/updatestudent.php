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
            $s_id = $_GET['s_id'];
            $sqlquery = mysqli_query($connection, "SELECT * FROM `student` INNER JOIN `testdate` ON student.tdID = testdate.tdID INNER JOIN `testresult` ON testdate.tdID = testresult.tdID WHERE testresult.s_id = $s_id");
            $data = mysqli_fetch_assoc($sqlquery);
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
                mysqli_query($connection, "UPDATE `student` SET `tdID`='$tdID', `name`='" . $_POST['name'] . "', `birthdate`='" . $_POST['bday'] . "', `height`='" . $_POST['height'] . "', `weight`='" . $_POST['weight'] . "', `sex`='" . $_POST['sex'] . "', `age`='" . $_POST['age'] . "', `BMI`='$bmi', `nutritional status`='" . $_POST['nutritionalstatus'] . "', `heightforage`='" . $_POST['heightforage'] . "' WHERE `s_id`= $s_id");
                mysqli_query($connection, "UPDATE `testresult` SET `tdID`='$tdID', `HRbefore`='" . $_POST['HRbefore'] . "', `HRafter`='" . $_POST['HRafter'] . "', `pushupsNo`='" . $_POST['pushups'] . "', `plankTime`='" . $_POST['plank'] . "', `zipperRight`='" . $_POST['zipperR'] . "', `zipperLeft`='" . $_POST['zipperL'] . "', `SaR1`='" . $_POST['sar1'] . "', `SaR2`='" . $_POST['sar2'] . "', `juggling`='" . $_POST['juggling'] . "', `hexagonClockwise`='" . $_POST['hexclock'] . "', `hexagonCounter`='" . $_POST['hexcounter'] . "', `sprintTime`='" . $_POST['sprinttime'] . "', `SLJ1`='" . $_POST['slj1'] . "', `SLJ2`='" . $_POST['slj2'] . "', `storkRight`='" . $_POST['storkright'] . "', `storkLeft`='" . $_POST['storkleft'] . "', `stick1`='" . $_POST['stick1'] . "', `stick2`='" . $_POST['stick2'] . "', `stick3`='" . $_POST['stick3'] . "')");
                echo '<script>alert("Updated data successfully");</script>';
                echo '<script>window.location.replace("list.php");</script>';
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
                <a class="here" href="list.php">Student List</a>
                <a href="result.php">Test Results</a>
                <a href="profile.php"><img class="profile" src="assets/wprof.png"></a>
            </div>
        </nav>
        <div class="addform">
            <form method="POST">
                <h1>Physical Fitness Test <?php $interpretation = zippertest_interpretation($data['zipperRight']); echo $interpretation;?></h1>

                <select name="syear">
                    <?php
                    while ($row1 = mysqli_fetch_array($syears)) {
                        ?>
                        <option value='<?php echo $row1['sy_id']; ?>' <?php
                        if ($row1['sy_id'] == $data['sy_id']) {
                            echo 'selected';
                        }
                        ?>><?php echo $row1['year']; ?></option>
                                <?php
                            }
                            ?>
                </select>
                <select name="quarter">
                    <?php
                    while ($qtr = mysqli_fetch_array($quarter)) {
                        ?>
                        <option value='<?php echo $qtr['q_id']; ?>' <?php
                        if ($qtr['q_id'] == $data['q_id']) {
                            echo 'selected';
                        }
                        ?>><?php echo $qtr['quarter']; ?></option>
                                <?php
                            }
                            ?>
                </select>
                <select name="testtype">
                    <?php
                    while ($tt = mysqli_fetch_array($testtype)) {
                        ?>
                        <option value='<?php echo $tt['testID']; ?>' <?php
                        if ($tt['testID'] == $data['testID']) {
                            echo 'selected';
                        }
                        ?>><?php echo $tt['testtype']; ?></option>
                                <?php
                            }
                            ?>
                </select>

                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo $data['name'] ?>" required>
                <label for="bday">Birth Date:</label>
                <input type="date" name="bday" value="<?php echo $data['birthdate'] ?>" required>
                <label for="sex">Sex:</label>
                <select name="sex">
                    <option value="Male" <?php
                    if ($data['sex'] == "Male") {
                        echo 'selected';
                    }
                    ?>>Male</option>
                    <option value="Female" <?php
                    if ($data['sex'] == "Female") {
                        echo 'selected';
                    }
                    ?>>Female</option>
                </select>
                <label for="age">Age:</label>
                <input type="number" name="age" value="<?php echo $data['age'] ?>" required>
                <label for="height">Height(m):</label>
                <input type="number" name="height" step="0.01" value="<?php echo $data['height'] ?>" required>
                <label for="weight">Weight(kg):</label>
                <input type="number" name="weight" step="0.01" value="<?php echo $data['weight'] ?>" required>
                <label for="nutritionalstatus">Nutritional Status:</label>
                <select name="nutritionalstatus">
                    <option value="Severely Wasted" <?php
                    if ($data['nutritional status'] == "Severely Wasted") {
                        echo 'selected';
                    }
                    ?>>Severely Wasted</option>
                    <option value="Wasted" <?php
                    if ($data['nutritional status'] == "Wasted") {
                        echo 'selected';
                    }
                    ?>>Wasted</option>
                    <option value="Normal" <?php
                    if ($data['nutritional status'] == "Normal") {
                        echo 'selected';
                    }
                    ?>>Normal</option>
                    <option value="Overweight" <?php
                    if ($data['nutritional status'] == "Overweight") {
                        echo 'selected';
                    }
                    ?>>Overweight</option>
                    <option value="Obese" <?php
                    if ($data['nutritional status'] == "Obese") {
                        echo 'selected';
                    }
                    ?>>Obese</option>
                </select>
                <label for="heightforage">Height-for-Age:</label>
                <select name="heightforage">
                    <option value="Severely Stunted" <?php
                    if ($data['heightforage'] == "Severely Stunted") {
                        echo 'selected';
                    }
                    ?>>Severely Stunted</option>
                    <option value="Stunted" <?php
                    if ($data['heightforage'] == "Stunted") {
                        echo 'selected';
                    }
                    ?>>Stunted</option>
                    <option value="Normal" <?php
                    if ($data['heightforage'] == "Normal") {
                        echo 'selected';
                    }
                    ?>>Normal</option>
                    <option value="Tall" <?php
                    if ($data['heightforage'] == "Tall") {
                        echo 'selected';
                    }
                    ?>>Tall</option>
                </select>
                <label for="HRbefore">Heart Rate Before Activity(bpm):</label>
                <input type="number" name="HRbefore" step="0.01" value="<?php echo $data['HRbefore'] ?>" required>
                <label for="HRafter">Heart Rate After Activity(bpm):</label>
                <input type="number" name="HRafter" step="0.01" value="<?php echo $data['HRafter'] ?>" required>
                <label for="pushups">No. of Push Ups:</label>
                <input type="number" name="pushups" value="<?php echo $data['pushupsNo'] ?>" required>
                <label for="plank">Basic Plank Time(sec):</label>
                <input type="number" name="plank" value="<?php echo $data['plankTime'] ?>" required>
                <label for="zipperR">Zipper Test Overlap/Gap Right(cm):</label>
                <input type="number" name="zipperR" step="0.01" value="<?php echo $data['zipperRight'] ?>" required>
                <label for="zipperL">Zipper Test Overlap/Gap Left(cm):</label>
                <input type="number" name="zipperL" step="0.01" value="<?php echo $data['zipperLeft'] ?>" required>
                <label for="sar1">Sit and Reach Score 1st Try(cm):</label>
                <input type="number" name="sar1" step="0.01" value="<?php echo $data['SaR1'] ?>" required>
                <label for="sar2">Sit and Reach Score 2nd Try(cm):</label>
                <input type="number" name="sar2" step="0.01" value="<?php echo $data['SaR2'] ?>" required>
                <br>
                <label for="juggling">Juggling:</label>
                <input type="number" name="juggling" value="<?php echo $data['juggling'] ?>" required>
                <label for="hexclock">Hexagon Agility Test Clockwise Time(sec):</label>
                <input type="number" name="hexclock" value="<?php echo $data['hexagonClockwise'] ?>" required>
                <label for="hexcounter">Hexagon Agility Test Counter Clockwise Time(sec):</label>
                <input type="number" name="hexcounter" value="<?php echo $data['hexagonCounter'] ?>" required>
                <label for="sprinttime">40-Meter Sprint(min.sec):</label>
                <input type="number" name="sprinttime" step="0.01" value="<?php echo $data['sprintTime'] ?>" required>
                <label for="slj1">Standing Long Jump 1st Trial(cm):</label>
                <input type="number" name="slj1" step="0.01" value="<?php echo $data['SLJ1'] ?>" required>
                <label for="slj2">Standing Long Jump 2nd Trial(cm):</label>
                <input type="number" name="slj2" step="0.01" value="<?php echo $data['SLJ2'] ?>" required>
                <label for="storkright">Stork Balance Stand Test Right Feet(sec):</label>
                <input type="number" name="storkright" value="<?php echo $data['storkRight'] ?>" required>
                <label for="storkleft">Stork Balance Stand Test Left Feet(sec):</label>
                <input type="number" name="storkleft" value="<?php echo $data['storkLeft'] ?>" required>
                <label for="stick1">Stick Drop Test 1st Trial(cm):</label>
                <input type="number" name="stick1" step="0.01" value="<?php echo $data['stick1'] ?>" required>
                <label for="stick2">Stick Drop Test 2nd Trial(cm):</label>
                <input type="number" name="stick2" step="0.01" value="<?php echo $data['stick2'] ?>" required>
                <label for="stick3">Stick Drop Test 3rd Trial(cm):</label>
                <input type="number" name="stick3" step="0.01" value="<?php echo $data['stick3'] ?>" required><br>
                <input type="submit" name="cancel" value="Cancel" formnovalidate>
                <input type="submit" name="save" value="Save">
            </form>
        </div>
    </body>
</html>
