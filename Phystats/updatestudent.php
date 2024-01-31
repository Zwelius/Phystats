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
            $bmi = number_format((float) $temp, 1, '.', '');
            $bmiClassification = bmiclassification($_POST['sex'], $age, $bmi);

            mysqli_query($connection, "UPDATE `student_tb` SET `studentNAME`='" . $_POST['name'] . "', `studentBIRTHDATE`='" . $_POST['bday'] . "', `studentSEX`='" . $_POST['sex'] . "' WHERE `student_ID`= $student_ID");
            mysqli_query($connection, "UPDATE `studenttestdata_tb` SET `testinfo_ID`='$testinfo_ID', `height`='" . $_POST['height'] . "', `weight`='" . $_POST['weight'] . "', `BMI`='$bmi', `bmiClassification`='$bmiClassification', `HRbefore`='" . $_POST['HRbefore'] . "', `HRafter`='" . $_POST['HRafter'] . "', `pushupsNo`='" . $_POST['pushups'] . "', `plankTime`='" . $_POST['plank'] . "', `zipperRight`='" . $_POST['zipperR'] . "', `zipperLeft`='" . $_POST['zipperL'] . "', `sitReach1`='" . $_POST['sar1'] . "', `sitReach2`='" . $_POST['sar2'] . "', `juggling`='" . $_POST['juggling'] . "', `hexagonClockwise`='" . $_POST['hexclock'] . "', `hexagonCounter`='" . $_POST['hexcounter'] . "', `sprintTime`='" . $_POST['sprinttime'] . "', `longJump1`='" . $_POST['slj1'] . "', `longJump2`='" . $_POST['slj2'] . "', `storkRight`='" . $_POST['storkright'] . "', `storkLeft`='" . $_POST['storkleft'] . "', `stickDrop1`='" . $_POST['stick1'] . "', `stickDrop2`='" . $_POST['stick2'] . "', `stickDrop3`='" . $_POST['stick3'] . "' WHERE `testdata_ID` = $testdata_ID");

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
            echo '<script>window.location.replace("viewstudent.php?student_ID=' . $data["student_ID"] . '");</script>';
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

    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <form method="POST">
                <span class="close" id="closeAddStudent">&#129092;</span>

                <div class="tabs">
                    <div class="tab">Edit Information</div>
                </div>

                <div class="progress-bar"></div>

                <div class="content">
                    <div id="tab1" class="tab-content">
                        <table class="add-students-table">
                            <tr>
                                <th colspan="2"><label for="syear">SCHOOL YEAR</label></th>
                                <th colspan="2"><label for="quarter">QUARTER</label></th>
                                <th colspan="2"><label for="testtype">TEST TYPE</label></th>
                            </tr>
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
                                <th colspan="6"><label for="name">FULL NAME</label></th>
                            </tr>
                            <tr>
                                <th colspan="6"><input type="text" name="name"
                                        value="<?php echo $data['studentNAME'] ?>" required>
                                </th>
                                <th>&nbsp;</th><!--empty-->
                            </tr>

                            <tr>
                                <th colspan="2"><label for="bday">BIRTH DATE</label></th>
                                <th colspan="2"><label for="sex">SEX</label></th>
                            </tr>

                            <tr>
                                <th colspan="2"><input type="date" name="bday"
                                        value="<?php echo $data['studentBIRTHDATE'] ?>"
                                        min="<?php echo date("Y-m-d", strtotime("-17 years")); ?>"
                                        max="<?php echo date("Y-m-d", strtotime("-6 years")); ?>" required></th>
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
                            </tr>
                        </table>
                    </div>
                    <!--end of student info tab-->

                    <!--start of health related test-->
                    <div id="tab2" class="tab-content">
                        <table class="add-students-table">
                            <tr>
                                <th colspan="2" class="category"><label for="category">BODY
                                        COMPOSITION</label><br><label>Body Mass Index (BMI)</label>
                                </th>
                                <th colspan="2" class="category"><label for="category">CARDIOVASCULAR
                                        ENDURANCE</label><br><label>3-MINUTE STEP (Heart rate per minute)</label>
                                </th>
                            </tr>

                            <br><hr><br>

                            <tr>
                                <th><label for="height">HEIGHT (m):</label><br><input type="number" name="height"
                                        min="0" step="0.01" value="<?php echo $data['height'] ?>" required>
                                </th>
                                <th><label for="weight">WEIGHT (kg):</label><br><input type="number" name="weight"
                                        min="0" step="0.01" value="<?php echo $data['weight'] ?>" required>
                                </th>
                                <th><label for="HRbefore">Before Activity</label><br><input type="number"
                                        name="HRbefore" step="0.01" min="40" max="220"
                                        value="<?php echo $data['HRbefore'] ?>" required></th>
                                <th><label for="HRafter">After Activity</label><br><input type="number" name="HRafter"
                                        step="0.01" min="40" max="220" value="<?php echo $data['HRafter'] ?>" required>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4">&nbsp;</th><!--empty-->
                            </tr>
                            <tr>
                                <th colspan="2" class="category"><label for="category">FLEXIBILITY</label><br><label
                                        for="zipper">ZIPPER TEST OVERLAP/GAP (cm)</label></th>
                                <th colspan="2"><br><label for="sar">SIT AND REACH SCORE (cm)</label></th>
                            </tr>
                            <tr>
                                <th><label for="zipperL">Left</label><br><input type="number" name="zipperL" step="0.01"
                                        value="<?php echo $data['zipperLeft'] ?>" required></th>
                                <th><label for="zipperR">Right</label><br><input type="number" name="zipperR"
                                        step="0.01" value="<?php echo $data['zipperRight'] ?>" required></th>
                                <th><label for="sar1">First Trial</label><br><input type="number" name="sar1"
                                        step="0.01" min="0" value="<?php echo $data['sitReach1'] ?>" required></th>
                                <th><label for="sar2">Second Trial</label><br><input type="number" name="sar2"
                                        step="0.01" min="0" value="<?php echo $data['sitReach2'] ?>" required></th>
                            </tr>
                            <tr>
                                <th colspan="2">&nbsp;</th><!--empty-->
                            </tr>
                            <tr>
                                <th colspan="2" class="category"><label for="category">STRENGTH</label></th>
                            </tr>
                            <tr>
                                <th><label for="pushups">NO. OF PUSH UPS</label><br><input type="number" name="pushups"
                                        min="0" value="<?php echo $data['pushupsNo'] ?>" required></th>
                                <th><label for="plank">BASIC PLANK (sec)</label><br><input type="number" name="plank"
                                        min="0" value="<?php echo $data['plankTime'] ?>" required></th>
                            </tr>
                        </table>
                    </div>
                    <!--end of health related test-->

                    <br><hr><br>

                    <!--start of skill related test-->
                    <div id="tab3" class="tab-content">
                        <table class="add-students-table">
                            <tr>
                                <th class="category"><label for="category">COORDINATION</label></th>
                                <th class="category"><label for="category">SPEED</label></th>
                                <th colspan="2" class="category"><label for="category">POWER</label></th>
                            </tr>
                            <tr>
                                <th><label for="juggling">Juggling:</label></th>
                                <th><label for="sprinttime">40 METER SPRINT (sec)</label></th>
                                <th colspan="2"><label for="slg">STANDING LONG JUMP (cm)</label></th>
                            </tr>
                            <tr>
                                <th><br><input type="number" name="juggling" value="<?php echo $data['juggling'] ?>"
                                        min="0" required></th>
                                <th><br><input type="number" name="sprinttime" step="0.01"
                                        value="<?php echo $data['sprintTime'] ?>" min="0" required></th>
                                <th><label for="slj1">First Trial</label><br><input type="number" name="slj1"
                                        step="0.01" value="<?php echo $data['longJump1'] ?>" min="0" required></th>
                                <th><label for="slj2">Second Trial</label><br><input type="number" name="slj2"
                                        step="0.01" value="<?php echo $data['longJump2'] ?>" min="0" required>
                                </th>
                            </tr>

                            <tr>
                                <th>&nbsp;</th><!--empty-->
                            </tr>

                            <tr>
                                <th colspan="2" class="category"><label for="category">AGILITY</label></th>
                                <th colspan="2" class="category"><label for="category">BALANCE</label></th>
                            </tr>
                            <tr>
                                <th colspan="2"><label for="hexagon">HEXAGON AGILITY TEST (sec)</label></th>
                                <th colspan="2"><label for="stork-balance">STORK BALANCE TEST (sec)</label></th>
                            </tr>
                            <tr>
                                <th><label for="clockwise">Clockwise</label><br><input type="number" name="hexclock"
                                        value="<?php echo $data['hexagonClockwise'] ?>" min="0" required></th>
                                <th><label for="hexcounter">Counter Clockwise</label><br><input type="number"
                                        name="hexcounter" value="<?php echo $data['hexagonCounter'] ?>" min="0"
                                        required>
                                </th>
                                <th><label for="storkleft">Left Foot</label><br><input type="number" name="storkleft"
                                        value="<?php echo $data['storkLeft'] ?>" min="0" required></th>
                                <th><label for="storkright">Right Foot</label><br><input type="number" name="storkright"
                                        value="<?php echo $data['storkRight'] ?>" min="0" required>
                            </tr>
                            <tr>
                                <th colspan="4">&nbsp;</th><!--empty-->
                            </tr>
                            <tr>
                                <th colspan="2" class="category"><label for="category">REACTION TIME</label></th>
                            </tr>
                            <tr>
                                <th colspan="2"><label for="stick">STICK DROP TEST (cm)</label></th>
                            </tr>
                            <tr>
                                <th><label for="stick1">First Trial</label><br><input type="number" name="stick1"
                                        step="0.01" value="<?php echo $data['stickDrop1'] ?>" min="0" max="30.48"
                                        required>
                                </th>
                                <th><label for="stick2">Second Trial</label><br><input type="number" name="stick2"
                                        step="0.01" value="<?php echo $data['stickDrop2'] ?>" min="0" max="30.48"
                                        required>
                                </th>
                                <th><label for="stick3">Third Trial</label><br><input type="number" name="stick3"
                                        step="0.01" value="<?php echo $data['stickDrop3'] ?>" min="0" max="30.48"
                                        required>
                                </th>
                            </tr>
                        </table>
                        <div class="button-container">
                            <input type="submit" name="save" value="Save" onclick="submitTab()">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        //modal
        //var modal = document.getElementById('addStudentModal');
        //var open = document.getElementById('openAddStudent');
        var close = document.getElementById('closeAddStudent');

        //open.onclick = function () {
        //    modal.style.display = 'block';
        //}

        close.onclick = function () {
            //modal.style.display = 'none';
            window.location.replace("viewstudent.php?student_ID=<?php echo $data['student_ID']; ?>");
        }

        //validation thingy
        function validateStudentInformation() {
            const name = document.querySelector('input[name="name"]').value;
            const bday = document.querySelector('input[name="bday"]').value;
            const sex = document.querySelector('select[name="sex"]').value;

            if (name === "" || bday === "" || sex === "") {
                alert("Please fill in all required fields in student information.");
                return false;
            }

            return true;
        }

        function validateHealthRelated() {
            const height = document.querySelector('input[name="height"]').value;
            const weight = document.querySelector('input[name="weight"]').value;
            const HRbefore = document.querySelector('input[name="HRbefore"]').value;
            const HRafter = document.querySelector('input[name="HRafter"]').value;
            const zipperL = document.querySelector('input[name="zipperL"]').value;
            const zipperR = document.querySelector('input[name="zipperR"]').value;
            const sar1 = document.querySelector('input[name="sar1"]').value;
            const sar2 = document.querySelector('input[name="sar2"]').value;
            const pushups = document.querySelector('input[name="pushups"]').value;
            const plank = document.querySelector('input[name="plank"]').value;

            if (height === "" || weight === "" || HRbefore === "" || HRafter === "" ||
                zipperL === "" || zipperR === "" || sar1 === "" || sar2 === "" ||
                pushups === "" || plank === "") {
                alert("Please fill in all required fields in health-related.");
                return false;
            }

            return true;
        }

        function validateSkillRelated() {
            const juggling = document.querySelector('input[name="juggling"]').value;
            const sprinttime = document.querySelector('input[name="sprinttime"]').value;
            const slj1 = document.querySelector('input[name="slj1"]').value;
            const slj2 = document.querySelector('input[name="slj2"]').value;
            const hexclock = document.querySelector('input[name="hexclock"]').value;
            const hexcounter = document.querySelector('input[name="hexcounter"]').value;
            const storkleft = document.querySelector('input[name="storkleft"]').value;
            const storkright = document.querySelector('input[name="storkright"]').value;
            const stick1 = document.querySelector('input[name="stick1"]').value;
            const stick2 = document.querySelector('input[name="stick2"]').value;
            const stick3 = document.querySelector('input[name="stick3"]').value;

            if (juggling === "" || sprinttime === "" || slj1 === "" || slj2 === "" ||
                hexclock === "" || hexcounter === "" || storkleft === "" || storkright === "" ||
                stick1 === "" || stick2 === "" || stick3 === "") {
                alert("Please fill in all required fields in skill-related.");
                return false;
            }

            return true;
        }

        //tabs

        function submitTab() {
            if (!validateStudentInformation()) {
                return;
            }
            if (!validateHealthRelated()) {
                return;
            }
            if (!validateSkillRelated()) {
                return;
            }
        }
    </script>
</body>

</html>