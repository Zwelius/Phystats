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
    <title>Phystats - Edit Students</title>
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/add.css" />
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
        $sqlquery = mysqli_query($connection, "SELECT * FROM `student` INNER JOIN `testdate` ON student.tdID = testdate.tdID INNER JOIN `testresult` ON testdate.tdID = testresult.tdID WHERE student.s_id = $s_id AND testresult.s_id = $s_id");
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
            mysqli_query($connection, "UPDATE `testresult` SET `tdID`='$tdID', `HRbefore`='" . $_POST['HRbefore'] . "', `HRafter`='" . $_POST['HRafter'] . "', `pushupsNo`='" . $_POST['pushups'] . "', `plankTime`='" . $_POST['plank'] . "', `zipperRight`='" . $_POST['zipperR'] . "', `zipperLeft`='" . $_POST['zipperL'] . "', `SaR1`='" . $_POST['sar1'] . "', `SaR2`='" . $_POST['sar2'] . "', `juggling`='" . $_POST['juggling'] . "', `hexagonClockwise`='" . $_POST['hexclock'] . "', `hexagonCounter`='" . $_POST['hexcounter'] . "', `sprintTime`='" . $_POST['sprinttime'] . "', `SLJ1`='" . $_POST['slj1'] . "', `SLJ2`='" . $_POST['slj2'] . "', `storkRight`='" . $_POST['storkright'] . "', `storkLeft`='" . $_POST['storkleft'] . "', `stick1`='" . $_POST['stick1'] . "', `stick2`='" . $_POST['stick2'] . "', `stick3`='" . $_POST['stick3'] . "' WHERE `s_id` = $s_id");
            $tr_ID = mysqli_query($connection, "SELECT `tr_ID` from `testresult` INNER JOIN `student` ON student.s_id = testresult.s_id WHERE testresult.s_id = $s_id");
            $row = mysqli_fetch_assoc($tr_ID);
            $tr_ID = $row['tr_ID'];
            $bodyComposition = $_POST['nutritionalstatus'];
            $cardiovascularEndurance = cardiovasulcarEndurance($_POST['HRbefore'], $_POST['HRafter'], $_POST['age']);
            $strength = strength($_POST['pushups'], $_POST['plank']);
            $flexibility = flexibility($_POST['zipperR'], $_POST['zipperL'], $_POST['sar1'], $_POST['sar2']);
            $coordination = coordination($_POST['juggling']);
            $agility = agility($_POST['hexclock'], $_POST['hexcounter']);
            $speed = speed($_POST['sprinttime'], $_POST['age'], $_POST['sex']);
            $power = power($_POST['slj1'], $_POST['slj2']);
            $balance = balance($_POST['storkright'], $_POST['storkleft'], $_POST['age']);
            $reactionTime = reactionTime($_POST['stick1'], $_POST['stick2'], $_POST['stick3']);
            $fitnessResult = physicallyFit($bodyComposition, $cardiovascularEndurance, $strength, $flexibility, $coordination, $agility, $speed, $power, $balance, $reactionTime);
            mysqli_query($connection, "UPDATE `resultinterpretation` SET `bodyComposition`= '$bodyComposition', `cardiovascularEndurance`= '$cardiovascularEndurance', `strength`= '$strength', `flexibility`= '$flexibility', `coordination`= '$coordination', `agility`= '$agility', `speed`= '$speed', `power`= '$power', `balance`= '$balance', `reactionTime`= '$reactionTime', `fitnessResult`= '$fitnessResult' WHERE `tr_ID` = $tr_ID");
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
            <a href="list.php" class="here nav-options">STUDENT LIST</a>
            <a href="result.php" class="nav-options">TEST RESULTS</a>
            <a href="profile.php" class="nav-options"><img class="profile" src="assets/wprof.png"></a>
        </div>
    </nav>

    <div class="add-form">
        <form method="POST">
            <p>Physical Fitness Test | Edit</p>
            <div class="tab-container">
                <input type="radio" id="student-information" name="tab-container" checked="checked">
                <label for="student-information">Student Information</label>
                <div class="tab">
                    <table class="student-information-table">
                        <tr>
                            <th colspan="2"><label for="syear">SCHOOL YEAR</label></th>
                            <th colspan="2"><label for="quarter">QUARTER</label></th>
                            <th colspan="2"><label for="testtype">TEST TYPE</label></th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <select name="syear">
                                    <?php
                                    while ($row1 = mysqli_fetch_array($syears)) {
                                        ?>
                                        <option value='<?php echo $row1['sy_id']; ?>' <?php
                                           if ($row1['sy_id'] == $data['sy_id']) {
                                               echo 'selected';
                                           }
                                           ?>><?php echo $row1['year']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </th>
                            <th colspan="2">
                                <select name="quarter">
                                    <?php
                                    while ($qtr = mysqli_fetch_array($quarter)) {
                                        ?>
                                        <option value='<?php echo $qtr['q_id']; ?>' <?php
                                           if ($qtr['q_id'] == $data['q_id']) {
                                               echo 'selected';
                                           }
                                           ?>><?php echo $qtr['quarter']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </th>
                            <th colspan="2">
                                <select name="testtype">
                                    <?php
                                    while ($tt = mysqli_fetch_array($testtype)) {
                                        ?>
                                        <option value='<?php echo $tt['testID']; ?>' <?php
                                           if ($tt['testID'] == $data['testID']) {
                                               echo 'selected';
                                           }
                                           ?>><?php echo $tt['testtype']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </th>
                        </tr>

                        <tr>
                            <!--empty-->
                            <th colspan="6">&nbsp;</th>
                        </tr>

                        <tr>
                            <th colspan="6"><label for="name">NAME</label></th>
                            <th colspan="2">&nbsp;</th><!--empty-->
                            <th><label for="nutritionalstatus">NUTRITIONAL STATUS</label></th>
                        </tr>
                        <tr>
                            <th colspan="6"><input type="text" name="name" value="<?php echo $data['name'] ?>" required>
                            </th>
                            <th colspan="2">&nbsp;</th><!--empty-->
                            <th>
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
                            </th>
                        </tr>

                        <tr>
                            <th colspan="2"><label for="bday">BIRTH DATE</label></th>
                            <th colspan="2"><label for="sex">SEX</label></th>
                            <th colspan="2"><label for="age">AGE</label></th>
                            <th colspan="2">&nbsp;</th><!--empty-->
                            <th colspan="2"><label for="heightforage">HEIGHT-FOR-AGE</label></th>
                        </tr>

                        <tr>
                            <th colspan="2"><input type="date" name="bday" value="<?php echo $data['birthdate'] ?>"
                                    required></th>
                            <th colspan="2">
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
                            </th>
                            <th colspan="2">
                                <input type="number" name="age" value="<?php echo $data['age'] ?>" required>
                            </th>
                            <th colspan="2">&nbsp;</th><!--empty-->
                            <th colspan="2">
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
                            </th>
                        </tr>
                        <tr>
                            <!--empty-->
                            <th colspan="6">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="2"><label for="height">HEIGHT (m):</label></th>
                            <th colspan="2"><label for="weight">WEIGHT (kg):</label></th>
                        </tr>
                        <tr>
                            <th colspan="2"><input type="number" name="height" step="0.01"
                                    value="<?php echo $data['height'] ?>" required></th>
                            <th colspan="2"><input type="number" name="weight" step="0.01"
                                    value="<?php echo $data['weight'] ?>" required></th>
                        </tr>
                    </table>
                </div>
                <!--end of student info tab-->

                <!--start of health related test-->
                <input type="radio" id="health-related-test" name="tab-container">
                <label for="health-related-test">Health-Related Test</label>
                <div class="tab">
                    <table class="health-related-test">
                        <tr>
                            <th colspan="2" class="category"><label for="category">CARDIOVASCULAR
                                    ENDURANCE</label><br><label>3-MINUTE STEP (Heart rate per minute)</label></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th colspan="2" class="category"><label for="category">FLEXIBILITY</label><br><label
                                    for="zipper">ZIPPER TEST OVERLAP/GAP (cm)</label></th>

                        </tr>
                        <tr>
                            <th><label for="HRbefore">Before Activity</label><br><input type="number" name="HRbefore"
                                    step="0.01" value="<?php echo $data['HRbefore'] ?>" required>
                            </th>
                            <th><label for="HRafter">After Activity</label><br><input type="number" name="HRafter"
                                    step="0.01" value="<?php echo $data['HRafter'] ?>" required></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th><label for="zipperL">Left</label><br><input type="number" name="zipperL" step="0.01"
                                    value="<?php echo $data['zipperLeft'] ?>" required></th>
                            <th><label for="zipperR">Right</label><br><input type="number" name="zipperR" step="0.01"
                                    value="<?php echo $data['zipperRight'] ?>" required></th>
                        </tr>
                        <tr>
                            <th colspan="2">&nbsp;</th><!--empty-->
                        </tr>
                        <tr>
                            <th colspan="5" class="category"><label for="category">STRENGTH</label></th>
                            <th><label for="sar">SIT AND REACH SCORE (cm)</label></th>
                        </tr>
                        <tr>
                            <th><label for="pushups">NO. OF PUSH UPS</label><br><input type="number" name="pushups"
                                    value="<?php echo $data['pushupsNo'] ?>" required></th>
                            <th><label for="plank">BASIC PLANK (sec)</label><br><input type="number" name="plank"
                                    value="<?php echo $data['plankTime'] ?>" required></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th><label for="sar1">First Trial</label><br><input type="number" name="sar1" step="0.01"
                                    value="<?php echo $data['SaR1'] ?>" required></th>
                            <th><label for="sar2">Second Trial</label><br><input type="number" name="sar2" step="0.01"
                                    value="<?php echo $data['SaR2'] ?>" required></th>
                        </tr>
                    </table>
                </div>
                <!--end of health related test-->

                <!--start of skill related test-->
                <input type="radio" id="skill-related-test" name="tab-container">
                <label for="skill-related-test">Skill-Related Test</label>
                <div class="tab">
                    <table class="skill-related-test">
                        <tr>
                            <th colspan="2" class="category"><label for="category">COORDINATION</label></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th colspan="2" class="category"><label for="category">POWER</label></th>
                        </tr>
                        <tr>
                            <th colspan="5">&nbsp;</th><!--empty-->
                            <th><label for="slg">STANDING LONG JUMP (cm)</label></th>
                        </tr>
                        <tr>
                            <th><label for="juggling">Juggling:</label><br><input type="number" name="juggling"
                                    value="<?php echo $data['juggling'] ?>" required></th>
                            <th colspan="4">&nbsp;</th><!--empty-->
                            <th><label for="slj1">First Trial</label><br><input type="number" name="slj1" step="0.01"
                                    value="<?php echo $data['SLJ1'] ?>" required>
                            </th>
                            <th><label for="slj2">Second Trial</label><br><input type="number" name="slj2" step="0.01"
                                    value="<?php echo $data['SLJ2'] ?>" required>
                            </th>
                        </tr>

                        <tr>
                            <th>&nbsp;</th><!--empty-->
                        </tr>

                        <tr>
                            <th colspan="2" class="category"><label for="category">AGILITY</label></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th colspan="2" class="category"><label for="category">BALANCE</label></th>
                        </tr>
                        <tr>
                            <th><label for="hexagon">HEXAGON AGILITY TEST (sec)</label></th>
                            <th colspan="4">&nbsp;</th><!--empty-->
                            <th><label for="stork-balance">STORK BALANCE TEST (sec)</label></th>
                        </tr>
                        <tr>
                            <th><label for="clockwise">Clockwise</label><br><input type="number" name="hexclock"
                                    value="<?php echo $data['hexagonClockwise'] ?>" required></th>
                            <th><label for="hexcounter">Counter Clockwise</label><br><input type="number"
                                    name="hexcounter" value="<?php echo $data['hexagonCounter'] ?>" required></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th><label for="storkleft">Left Foot</label><br><input type="number" name="storkleft"
                                    value="<?php echo $data['storkLeft'] ?>" required>
                            </th>
                            <th><label for="storkright">Right Foot</label><br><input type="number" name="storkright"
                                    value="<?php echo $data['storkRight'] ?>" required>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="5">&nbsp;</th><!--empty-->
                        </tr>

                        <tr>
                            <th colspan="5">&nbsp;</th><!--empty-->
                            <th colspan="2" class="category"><label for="category">REACTION TIME</label></th>
                        </tr>
                        <tr>
                            <th colspan="2" class="category"><label for="category">SPEED</label></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th colspan="2"><label for="stick">STICK DROP TEST (cm)</label></th>
                        </tr>
                        <tr>
                            <th><label for="sprinttime">40 METER SPRINT (sec)</label><br><input type="number"
                                    name="sprinttime" step="0.01" value="<?php echo $data['sprintTime'] ?>" required>
                            </th>
                            <th colspan="4">&nbsp;</th><!--empty-->
                            <th><label for="stick1">First Trial</label><br> <input type="number" name="stick1"
                                    step="0.01" value="<?php echo $data['stick1'] ?>" required>
                            </th>
                            <th><label for="stick2">Second Trial</label><br><input type="number" name="stick2"
                                    step="0.01" value="<?php echo $data['stick2'] ?>" required>
                            </th>
                            <th><label for="stick3">Third Trial</label><br><input type="number" name="stick3"
                                    step="0.01" value="<?php echo $data['stick3'] ?>" required>

                            </th>
                        </tr>
                    </table>
                </div>
                <!--end of skill related test-->
            </div>

            <div class="button-container">
                <div id="validation-message"></div>
                <input type="submit" name="save" value="Save">
                <input type="submit" name="cancel" value="Cancel" formnovalidate>
            </div>
        </form>
    </div>
</body>

</html>