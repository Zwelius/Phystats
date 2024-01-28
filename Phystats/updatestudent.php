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
    <link rel="icon" type="image/x-icon" href="assets/logo.ico">
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/add.css" />
</head>

<body>
    <?php
    include 'config.php';
    if (empty($_SESSION["teacher_ID"])) {
        header("Location: index.php");
    } else {
        $teacher_ID = $_SESSION["teacher_ID"];
        $testdata_ID = $_GET['testdata_ID'];

        $syears = mysqli_query($connection, "SELECT * FROM `schoolyear_tb` ORDER BY `schoolYEAR` DESC");
        $quarter = mysqli_query($connection, "SELECT * FROM `quarter_tb`");
        $testtype = mysqli_query($connection, "SELECT * FROM `testtype_tb`");
        $sqlquery = mysqli_query($connection, "SELECT * FROM `studenttestdata_tb` INNER JOIN `student_tb` ON student_tb.student_ID = studenttestdata_tb.student_ID INNER JOIN `testinfo_tb` ON studenttestdata_tb.testinfo_ID = testinfo_tb.testinfo_ID WHERE studenttestdata_tb.testdata_ID = $testdata_ID");
        $data = mysqli_fetch_assoc($sqlquery);

        if (isset($_POST['cancel'])) {
            header("Location: list.php");
        } else if (isset($_POST['save'])) {
            $query = mysqli_query($connection, "SELECT * FROM `testinfo_tb` WHERE `schoolyear_ID`='" . $_POST['syear'] . "' AND `quarter_ID`='" . $_POST['quarter'] . "' AND `testtype_ID`='" . $_POST['testtype'] . "' AND `teacher_ID`='$teacher_ID'");
            if ($query && mysqli_num_rows($query) < 1) {
                mysqli_query($connection, "INSERT INTO `testinfo_tb` (`schoolyear_ID`, `quarter_ID`, `testtype_ID`, `teacher_ID`) VALUES ('" . $_POST['syear'] . "','" . $_POST['quarter'] . "','" . $_POST['testtype'] . "','$teacher_ID')");
                $testinfo_ID = mysqli_insert_id($connection);
            } else {
                $row = mysqli_fetch_assoc($query);
                $testinfo_ID = $row['testinfo_ID'];
            }
            $testdata = mysqli_query($connection, "SELECT * FROM `studenttestdata_tb` INNER JOIN `student_tb` ON student_tb.student_ID = studenttestdata_tb.student_ID WHERE studenttestdata_tb.testdata_ID = $testdata_ID");
            $row = mysqli_fetch_assoc($testdata);
            $student_ID = $row['student_ID'];
            $age = $row['age'];

            $temp = $_POST['weight'] / ($_POST['height'] ** 2);
            $bmi = number_format((float) $temp, 2, '.', '');
            $bmiClassification = bmiclassification($_POST['sex'], $age, $bmi);

            mysqli_query($connection, "UPDATE `student_tb` SET `studentNAME`='" . $_POST['name'] . "', `studentBIRTHDATE`='" . $_POST['bday'] . "', `studentSEX`='" . $_POST['sex'] . "' WHERE `student_ID`= $student_ID");
            mysqli_query($connection, "UPDATE `studenttestdata_tb` SET `testinfo_ID`='$testinfo_ID', `height`='" . $_POST['height'] . "', `weight`='" . $_POST['weight'] . "', `BMI`='$bmi', `bmiClassification`='$bmiClassification', `HRbefore`='" . $_POST['HRbefore'] . "', `HRafter`='" . $_POST['HRafter'] . "', `pushupsNo`='" . $_POST['pushups'] . "', `plankTime`='" . $_POST['plank'] . "', `zipperRight`='" . $_POST['zipperR'] . "', `zipperLeft`='" . $_POST['zipperL'] . "', `sitReach1`='" . $_POST['sar1'] . "', `sitReach2`='" . $_POST['sar2'] . "', `juggling`='" . $_POST['juggling'] . "', `hexagonClockwise`='" . $_POST['hexclock'] . "', `hexagonCounter`='" . $_POST['hexcounter'] . "', `sprintTime`='" . $_POST['sprinttime'] . "', `longJump1`='" . $_POST['slj1'] . "', `longJump2`='" . $_POST['slj2'] . "', `storkRight`='" . $_POST['storkright'] . "', `storkLeft`='" . $_POST['storkleft'] . "', `stickDrop1`='" . $_POST['stick1'] . "', `stickDrop2`='" . $_POST['stick2'] . "', `stickDrop3`='" . $_POST['stick3'] . "' WHERE `student_ID` = $student_ID");

            $bodyComposition = $bmiClassification;
            $cardiovascularEndurance = cardiovasulcarEndurance($_POST['HRbefore'], $_POST['HRafter'], $age);
            $strength = strength($_POST['pushups'], $_POST['plank']);
            $flexibility = flexibility($_POST['zipperR'], $_POST['zipperL'], $_POST['sar1'], $_POST['sar2']);
            $coordination = coordination($_POST['juggling']);
            $agility = agility($_POST['hexclock'], $_POST['hexcounter']);
            $speed = speed($_POST['sprinttime'], $age, $_POST['sex']);
            $power = power($_POST['slj1'], $_POST['slj2']);
            $balance = balance($_POST['storkright'], $_POST['storkleft'], $age);
            $reactionTime = reactionTime($_POST['stick1'], $_POST['stick2'], $_POST['stick3']);
            $fitnessResult = physicallyFit($bodyComposition, $cardiovascularEndurance, $strength, $flexibility, $coordination, $agility, $speed, $power, $balance, $reactionTime);

            mysqli_query($connection, "UPDATE `studenttestresult_tb` SET `bodyComposition`= '$bodyComposition', `cardiovascularEndurance`= '$cardiovascularEndurance', `strength`= '$strength', `flexibility`= '$flexibility', `coordination`= '$coordination', `agility`= '$agility', `speed`= '$speed', `power`= '$power', `balance`= '$balance', `reactionTime`= '$reactionTime', `fitnessResult`= '$fitnessResult' WHERE `testdata_ID` = $testdata_ID");
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
                                        <option value='<?php echo $row1['schoolyear_ID']; ?>' <?php
                                           if ($row1['schoolyear_ID'] == $data['schoolyear_ID']) {
                                               echo 'selected';
                                           }
                                           ?>><?php echo $row1['schoolYEAR']; ?>
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
                                        <option value='<?php echo $qtr['quarter_ID']; ?>' <?php
                                           if ($qtr['quarter_ID'] == $data['quarter_ID']) {
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
                                        <option value='<?php echo $tt['testtype_ID']; ?>' <?php
                                           if ($tt['testtype_ID'] == $data['testtype_ID']) {
                                               echo 'selected';
                                           }
                                           ?>><?php echo $tt['testTYPE']; ?>
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
                            <th>&nbsp;</th><!--empty-->
                        </tr>
                        <tr>
                            <th colspan="6"><input type="text" name="name" value="<?php echo $data['studentNAME'] ?>" required>
                            </th>
                            <th>&nbsp;</th><!--empty-->
                        </tr>

                        <tr>
                            <th colspan="2"><label for="bday">BIRTH DATE</label></th>
                            <th colspan="2"><label for="sex">SEX</label></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                        </tr>

                        <tr>
                            <th colspan="2"><input type="date" name="bday" value="<?php echo $data['studentBIRTHDATE'] ?>"
                                    min="<?php echo date("Y-m-d", strtotime("-17 years")); ?>" max="<?php echo date("Y-m-d", strtotime("-6 years")); ?>" required></th>
                            <th colspan="2">
                                <select name="sex">
                                    <option value="Male" <?php
                                    if ($data['studentSEX'] == "Male") {
                                        echo 'selected';
                                    }
                                    ?>>Male</option>
                                    <option value="Female" <?php
                                    if ($data['studentSEX'] == "Female") {
                                        echo 'selected';
                                    }
                                    ?>>Female</option>
                                </select>
                            </th>
                            <th colspan="3">&nbsp;</th><!--empty-->
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
                                    value="<?php echo $data['height'] ?>" min="0" required></th>
                            <th colspan="2"><input type="number" name="weight" step="0.01"
                                    value="<?php echo $data['weight'] ?>" min="0" required></th>
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
                                    step="0.01" value="<?php echo $data['HRbefore'] ?>" min="40" max="220" required>
                            </th>
                            <th><label for="HRafter">After Activity</label><br><input type="number" name="HRafter"
                                    step="0.01" value="<?php echo $data['HRafter'] ?>" min="40" max="220" required></th>
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
                                    value="<?php echo $data['pushupsNo'] ?>" min="0" required></th>
                            <th><label for="plank">BASIC PLANK (sec)</label><br><input type="number" name="plank"
                                    value="<?php echo $data['plankTime'] ?>" min="0" required></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th><label for="sar1">First Trial</label><br><input type="number" name="sar1" step="0.01"
                                    value="<?php echo $data['sitReach1'] ?>" min="0" required></th>
                            <th><label for="sar2">Second Trial</label><br><input type="number" name="sar2" step="0.01"
                                    value="<?php echo $data['sitReach2'] ?>" min="0" required></th>
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
                                    value="<?php echo $data['juggling'] ?>" min="0" required></th>
                            <th colspan="4">&nbsp;</th><!--empty-->
                            <th><label for="slj1">First Trial</label><br><input type="number" name="slj1" step="0.01"
                                    value="<?php echo $data['longJump1'] ?>" min="0" required>
                            </th>
                            <th><label for="slj2">Second Trial</label><br><input type="number" name="slj2" step="0.01"
                                    value="<?php echo $data['longJump2'] ?>" min="0" required>
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
                                    value="<?php echo $data['hexagonClockwise'] ?>" min="0" required></th>
                            <th><label for="hexcounter">Counter Clockwise</label><br><input type="number"
                                    name="hexcounter" value="<?php echo $data['hexagonCounter'] ?>" min="0" required></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th><label for="storkleft">Left Foot</label><br><input type="number" name="storkleft"
                                    value="<?php echo $data['storkLeft'] ?>" min="0" required>
                            </th>
                            <th><label for="storkright">Right Foot</label><br><input type="number" name="storkright"
                                    value="<?php echo $data['storkRight'] ?>" min="0" required>
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
                                    name="sprinttime" step="0.01" value="<?php echo $data['sprintTime'] ?>" min="0" required>
                            </th>
                            <th colspan="4">&nbsp;</th><!--empty-->
                            <th><label for="stick1">First Trial</label><br> <input type="number" name="stick1"
                                    step="0.01" value="<?php echo $data['stickDrop1'] ?>" min="0" max="30.48" required>
                            </th>
                            <th><label for="stick2">Second Trial</label><br><input type="number" name="stick2"
                                    step="0.01" value="<?php echo $data['stickDrop2'] ?>" min="0" max="30.48" required>
                            </th>
                            <th><label for="stick3">Third Trial</label><br><input type="number" name="stick3"
                                    step="0.01" value="<?php echo $data['stickDrop3'] ?>" min="0" max="30.48" required>

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