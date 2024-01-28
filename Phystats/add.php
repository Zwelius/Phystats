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
        $syears = mysqli_query($connection, "SELECT * FROM `schoolyear_tb` ORDER BY `schoolYEAR` DESC");
        $quarter = mysqli_query($connection, "SELECT * FROM `quarter_tb`");
        $testtype = mysqli_query($connection, "SELECT * FROM `testtype_tb`");
        $grade = mysqli_query($connection, "SELECT * FROM `gradesection_tb` WHERE `teacher_ID` = '$teacher_ID'");
        $rows = mysqli_fetch_assoc($grade);
        $grade_ID = $rows["grade_ID"];

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
            $age = getAge($_POST['bday']);
            $temp = $_POST['weight'] / ($_POST['height'] ** 2);
            $bmi = number_format((float) $temp, 2, '.', '');
            $bmiClassification = bmiclassification($_POST['sex'], $age, $bmi);

            mysqli_query($connection, "INSERT INTO `student_tb` (`studentNAME`, `studentBIRTHDATE`, `studentSEX`) VALUES ('" . $_POST['name'] . "','" . $_POST['bday'] . "','" . $_POST['sex'] . "')");
            $student_ID = mysqli_insert_id($connection);
            mysqli_query($connection, "INSERT INTO `studenttestdata_tb`(`age`, `height`, `weight`, `BMI`, `bmiClassification`, `HRbefore`, `HRafter`, `pushupsNo`, `plankTime`, `zipperRight`, `zipperLeft`, `sitReach1`, `sitReach2`, `juggling`, `hexagonClockwise`, `hexagonCounter`, `sprintTime`, `longJump1`, `longJump2`, `storkRight`, `storkLeft`, `stickDrop1`, `stickDrop2`, `stickDrop3`, `student_ID`, `grade_ID`, `testinfo_ID`) VALUES ('$age','" . $_POST['height'] . "','" . $_POST['weight'] . "','$bmi','$bmiClassification','" . $_POST['HRbefore'] . "','" . $_POST['HRafter'] . "','" . $_POST['pushups'] . "','" . $_POST['plank'] . "','" . $_POST['zipperR'] . "','" . $_POST['zipperL'] . "','" . $_POST['sar1'] . "','" . $_POST['sar2'] . "','" . $_POST['juggling'] . "','" . $_POST['hexclock'] . "','" . $_POST['hexcounter'] . "','" . $_POST['sprinttime'] . "','" . $_POST['slj1'] . "','" . $_POST['slj2'] . "','" . $_POST['storkright'] . "','" . $_POST['storkleft'] . "','" . $_POST['stick1'] . "','" . $_POST['stick2'] . "','" . $_POST['stick3'] . "', '$student_ID', '$grade_ID','$testinfo_ID')");
            $testdata_ID = mysqli_insert_id($connection);
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
            mysqli_query($connection, "INSERT INTO `studenttestresult_tb`(`bodyComposition`, `cardiovascularEndurance`, `strength`, `flexibility`, `coordination`, `agility`, `speed`, `power`, `balance`, `reactionTime`, `fitnessResult`, `testdata_ID`) VALUES ('$bodyComposition', '$cardiovascularEndurance', '$strength', '$flexibility', '$coordination', '$agility', '$speed', '$power', '$balance', '$reactionTime', '$fitnessResult', '$testdata_ID')");
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
            <a href="list.php" class="here nav-options">STUDENT LIST</a>
            <a href="result.php" class="nav-options">TEST RESULTS</a>
            <a href="profile.php" class="nav-options"><img class="profile" src="assets/wprof.png"></a>
        </div>
    </nav>

    <!--<button id="openAddStudent">Add Student</button>-->

    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <form method="POST">
                <span class="close" id="closeAddStudent">&#129092;</span>

                <div class="tabs">
                    <div class="tab">Student Information</div>
                    <div class="tab">Health-Related</div>
                    <div class="tab">Skill-Related</div>
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
                            <tr>
                                <th colspan="2"><select name="syear">
                                        <?php
                                        while ($row1 = mysqli_fetch_array($syears)) {
                                            echo "<option value='" . $row1['schoolyear_ID'] . "'>" . $row1['schoolYEAR'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </th>

                                <th colspan="2"><select name="quarter">
                                        <?php
                                        while ($qtr = mysqli_fetch_array($quarter)) {
                                            echo "<option value='" . $qtr['quarter_ID'] . "'>" . $qtr['quarter'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </th>
                                <th colspan="2"><select name="testtype">
                                        <?php
                                        while ($tt = mysqli_fetch_array($testtype)) {
                                            echo "<option value='" . $tt['testtype_ID'] . "'>" . $tt['testTYPE'] . "</option>";
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
                                <th colspan="6"><input type="text" name="name" required></th>
                                <th>&nbsp;</th><!--empty-->
                            </tr>

                            <tr>
                                <th colspan="2"><label for="bday">BIRTH DATE</label></th>
                                <th colspan="2"><label for="sex">SEX</label></th>
                                <th colspan="3">&nbsp;</th><!--empty-->
                            </tr>

                            <tr>
                                <th colspan="2"><input type="date" name="bday"
                                        min="<?php echo date("Y-m-d", strtotime("-17 years")); ?>"
                                        max="<?php echo date("Y-m-d", strtotime("-6 years")); ?>" required></th>
                                <th colspan="2">
                                    <select name="sex">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </th>
                                <th colspan="3">&nbsp;</th><!--empty-->
                            </tr>
                            <tr>
                                <!--empty-->
                                <th colspan="6">&nbsp;</th>
                            </tr>
                        </table>
                        <div class="button-container">
                            <button class="next" onclick="nextTab()">Next</button>
                        </div>
                    </div>

                    <div id="tab2" class="tab-content" style="display: none;">
                        <table class="add-students-table">
                            <tr>
                                <th colspan="2" class="category"><label for="category">BODY
                                        COMPOSITION</label><br><label>Body Mass Index (BMI)</label>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2"><label for="height">HEIGHT (m):</label></th>
                                <th colspan="2"><label for="weight">WEIGHT (kg):</label></th>
                            </tr>
                            <tr>
                                <th colspan="3"><input type="number" name="height" min="0" step="0.01" required>
                                </th>
                                <th colspan="2"><input type="number" name="weight" min="0" step="0.01" required>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" class="category"><label for="category">CARDIOVASCULAR
                                        ENDURANCE</label><br><label>3-MINUTE STEP (Heart rate per minute)</label>
                                </th>
                                <th colspan="3">&nbsp;</th><!--empty-->
                                <th colspan="2" class="category"><label for="category">FLEXIBILITY</label><br><label
                                        for="zipper">ZIPPER TEST OVERLAP/GAP (cm)</label></th>
                            </tr>
                            <tr>
                                <th><label for="HRbefore">Before Activity</label><br><input type="number"
                                        name="HRbefore" step="0.01" min="40" max="220" required></th>
                                <th><label for="HRafter">After Activity</label><br><input type="number" name="HRafter"
                                        step="0.01" min="40" max="220" required></th>
                                <th colspan="3">&nbsp;</th><!--empty-->
                                <th><label for="zipperL">Left</label><br> <input type="number" name="zipperL"
                                        step="0.01" required></th>
                                <th><label for="zipperR">Right</label><br><input type="number" name="zipperR"
                                        step="0.01" required></th>
                            </tr>
                            <tr>
                                <th colspan="2">&nbsp;</th><!--empty-->
                            </tr>
                            <tr>
                                <th colspan="5" class="category"><label for="category">STRENGTH</label></th>
                                <th><label for="sar">SIT AND REACH SCORE (cm)</label></th>
                            </tr>
                            <tr>
                                <th><label for="pushups">NO. OF PUSH UPS</label><br> <input type="number" name="pushups"
                                        min="0" required></th>
                                <th><label for="plank">BASIC PLANK (sec)</label><br><input type="number" name="plank"
                                        min="0" required></th>
                                <th colspan="3">&nbsp;</th><!--empty-->
                                <th><label for="sar1">First Trial</label><br><input type="number" name="sar1"
                                        step="0.01" min="0" required></th>
                                <th><label for="sar2">Second Trial</label><br><input type="number" name="sar2"
                                        step="0.01" min="0" required></th>
                            </tr>
                        </table>
                        <div class="button-container">
                            <button class="previous" onclick="previousTab()">Previous</button>
                            <button class="next" onclick="nextTab()">Next</button>
                        </div>
                    </div>

                    <div id="tab3" class="tab-content" style="display: none;">
                        <table class="add-students-table">
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
                                        min="0" required></th>
                                <th colspan="4">&nbsp;</th><!--empty-->
                                <th><label for="slj1">First Trial</label><br>
                                    <input type="number" name="slj1" min="0" step="0.01" required>
                                </th>
                                <th><label for="slj2">Second Trial</label><br>
                                    <input type="number" name="slj2" min="0" step="0.01" required>
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
                                        min="0" required></th>
                                <th><label for="hexcounter">Counter Clockwise</label><br><input type="number"
                                        name="hexcounter" min="0" required></th>
                                <th colspan="3">&nbsp;</th><!--empty-->
                                <th><label for="storkleft">Left Foot</label><br><input type="number" name="storkleft"
                                        min="0" required>
                                </th>
                                <th><label for="storkright">Right Foot</label><br><input type="number" name="storkright"
                                        min="0" required>
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
                                        name="sprinttime" min="0" step="0.01" required>
                                </th>
                                <th colspan="4">&nbsp;</th><!--empty-->
                                <th><label for="stick1">First Trial</label><br><input type="number" name="stick1"
                                        step="0.01" min="0" max="30.48" required>
                                </th>
                                <th><label for="stick2">Second Trial</label><br><input type="number" name="stick2"
                                        step="0.01" min="0" max="30.48" required>
                                </th>
                                <th><label for="stick3">Third Trial</label><br><input type="number" name="stick3"
                                        step="0.01" min="0" max="30.48" required>
                                </th>
                            </tr>
                        </table>

                        <div class="button-container">
                            <button class="previous" onclick="previousTab()">Previous</button>
                            <input type="submit" name="save" value="Save">
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
            window.location.replace("list.php");
        }

        //tabs
        let currentTab = 1;
        function nextTab() {
            if (currentTab < 3) {
                document.getElementById(`tab${currentTab}`).style.display = 'none';
                currentTab++;
                document.getElementById(`tab${currentTab}`).style.display = 'block';
                updateProgressBar();
            }
        }

        function previousTab() {
            if (currentTab > 1) {
                document.getElementById(`tab${currentTab}`).style.display = 'none';
                currentTab--;
                document.getElementById(`tab${currentTab}`).style.display = 'block';
                updateProgressBar();
            }
        }

        function updateProgressBar() {
            const progressBar = document.querySelector('.progress-bar');
            progressBar.style.width = `${(currentTab - 1) * 50}%`;
        }
    </script>
</body>

</html>