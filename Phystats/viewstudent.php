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
    <title>Phystats - Student Info</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.ico">
    <link rel="stylesheet" href="css/nav.css">
    <!--
    <script defer>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("test_form").submit();
            console.log("Content loaded!");
        });
    </script>
    -->
</head>

<body>
    <?php
    include 'config.php';
    if (empty($_SESSION["teacher_ID"])) {
        header("Location: index.php");
    } else {
        $teacher_ID = $_SESSION["teacher_ID"];
        $student_ID = $_GET["student_ID"];
        $query = "SELECT * FROM `studenttestdata_tb` INNER JOIN `gradesection_tb` ON gradesection_tb.grade_ID = studenttestdata_tb.grade_ID INNER JOIN `testinfo_tb` ON testinfo_tb.testinfo_ID = studenttestdata_tb.testinfo_ID
         INNER JOIN `quarter_tb` ON quarter_tb.quarter_ID = testinfo_tb.quarter_ID INNER JOIN `testtype_tb` ON testtype_tb.testtype_ID = testinfo_tb.testtype_ID
         INNER JOIN `studenttestresult_tb` ON studenttestresult_tb.testdata_ID = studenttestdata_tb.testdata_ID WHERE `student_ID` = '$student_ID'";
        $gradesql = mysqli_query($connection, $query);
        $quartersql = mysqli_query($connection, $query);
        $testtypesql = mysqli_query($connection, $query);
        $sql = "SELECT * FROM `student_tb` WHERE `student_ID` = '$student_ID'";
        $studentinfo = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_array($studentinfo)) {
            $studentNAME = $row["studentNAME"];
            $studentBIRTHDATE = $row["studentBIRTHDATE"];
            $studentSEX = $row["studentSEX"];
        }
    }
    ?>
    <nav>
        <div>
            <img class="logo" src="assets/wlogo.png">
            <h1 class="title">Phystats</h1>
        </div>
    </nav>
    <button onclick="window.print();">Print</button>

    <div class="content">
        <h1><?php echo $studentNAME; ?></h1>
        <h3><?php echo $studentBIRTHDATE . "&nbsp;&nbsp;&nbsp;" . $studentSEX; ?></h3>
        <div>
            <form method="POST" id="test_form">
                <select name="grade" onload="this.form.submit()" onchange="this.form.submit()">
                    <?php
                    while ($gs = mysqli_fetch_array($gradesql)) {
                    ?>
                        <option value='<?php echo $gs['grade_ID']; ?>' <?php if (isset($_POST['grade']) && $_POST['grade'] === $gs['grade_ID']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $gs['grade'] . " - " . $gs['section']; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
                <select name="quarter" onload="this.form.submit()" onchange="this.form.submit()">
                    <?php
                    while ($qtr = mysqli_fetch_array($quartersql)) {
                    ?>
                        <option value='<?php echo $qtr['quarter_ID']; ?>' <?php if (isset($_POST['quarter']) && $_POST['quarter'] === $qtr['quarter_ID']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $qtr['quarter']; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
                <select name="testtype" onload="this.form.submit()" onchange="this.form.submit()">
                    <?php
                    while ($tt = mysqli_fetch_array($testtypesql)) {
                    ?>
                        <option value='<?php echo $tt['testtype_ID']; ?>' <?php if (isset($_POST['testtype']) && $_POST['testtype'] === $tt['testtype_ID']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $tt['testTYPE']; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </form>
            <?php
            $data = $query . "AND studenttestdata_tb.grade_ID = '" . $_POST['grade'] . "' AND testinfo_tb.quarter_ID = '" . $_POST['quarter'] . "' AND testinfo_tb.testtype_ID = '" . $_POST['testtype'] . "'";
            $thisdata = mysqli_query($connection, $data);
            if ($thisdata && mysqli_num_rows($thisdata) > 0) {
                while ($datarow = mysqli_fetch_array($thisdata)) {
            ?>
                    <div class="section1">
                        <?php echo "<a href='updatestudent.php?testdata_ID={$datarow['testdata_ID']}'><img class='action' src='assets/edit.png'></a>&nbsp;&nbsp;<a href='delete.php?testdata_ID={$datarow['testdata_ID']}'><img class='action' src='assets/delete.png'></a>"; ?>
                        <table class="add-students-table">
                            <tr>
                                <th colspan="2" class="category"><label for="category">BODY
                                        COMPOSITION</label><br><label>Body Mass Index (BMI)</label>
                                </th>
                                <th colspan="2" class="category"><label for="category">CARDIOVASCULAR
                                        ENDURANCE</label><br><label>3-MINUTE STEP (Heart rate per minute)</label>
                                </th>
                            </tr>
                            <tr>
                                <th><label for="height">HEIGHT (m):</label><br><input type="number" name="height" value="<?php echo $datarow['height']; ?>" min="0" step="0.01" readonly><br>
                                    <label for="weight">WEIGHT (kg):</label><br><input type="number" name="weight" value="<?php echo $datarow['weight']; ?>" min="0" step="0.01" readonly>
                                </th>
                                <th><label for="BMI">BMI</label><br><input type="number" name="BMI" value="<?php echo $datarow['BMI']; ?>" min="0" step="0.01" readonly><br>
                                    <label for="bmiClassification">BMI CLASSIFICATION</label><br><input type="text" name="bmiClassification" value="<?php echo $datarow['bmiClassification']; ?>" readonly>
                                </th>
                                <th><label for="HRbefore">Before Activity</label><br><input type="number" name="HRbefore" value="<?php echo $datarow['HRbefore']; ?>" step="0.01" min="40" max="220" readonly></th>
                                <th><label for="HRafter">After Activity</label><br><input type="number" name="HRafter" value="<?php echo $datarow['HRafter']; ?>" step="0.01" min="40" max="220" readonly></th>
                            </tr>
                            <tr>
                                <th colspan="4">&nbsp;</th><!--empty-->
                            </tr>
                            <tr>
                                <th colspan="2" class="category"><label for="category">FLEXIBILITY</label><br><label for="zipper">ZIPPER TEST OVERLAP/GAP (cm)</label></th>
                                <th colspan="2"><br><label for="sar">SIT AND REACH SCORE (cm)</label></th>
                            </tr>
                            <tr>
                                <th><label for="zipperL">Left</label><br> <input type="number" name="zipperL" value="<?php echo $datarow['zipperLeft']; ?>" step="0.01" readonly></th>
                                <th><label for="zipperR">Right</label><br><input type="number" name="zipperR" value="<?php echo $datarow['zipperRight']; ?>" step="0.01" readonly></th>
                                <th><label for="sar1">First Trial</label><br><input type="number" name="sar1" value="<?php echo $datarow['sitReach1']; ?>" step="0.01" min="0" readonly></th>
                                <th><label for="sar2">Second Trial</label><br><input type="number" name="sar2" value="<?php echo $datarow['sitReach2']; ?>" step="0.01" min="0" readonly></th>
                            </tr>
                            <tr>
                                <th colspan="2">&nbsp;</th><!--empty-->
                            </tr>
                            <tr>
                                <th colspan="2" class="category"><label for="category">STRENGTH</label></th>
                            </tr>
                            <tr>
                                <th><label for="pushups">NO. OF PUSH UPS</label><br> <input type="number" name="pushups" value="<?php echo $datarow['pushupsNo']; ?>" min="0" readonly></th>
                                <th><label for="plank">BASIC PLANK (sec)</label><br><input type="number" name="plank" value="<?php echo $datarow['plankTime']; ?>" min="0" readonly></th>
                            </tr>
                        </table>
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
                                <th><br><input type="number" name="juggling" value="<?php echo $datarow['juggling']; ?>" min="0" readonly></th>
                                <th><br><input type="number" name="sprinttime" value="<?php echo $datarow['sprintTime']; ?>" min="0" step="0.01" readonly></th>
                                <th><label for="slj1">First Trial</label><br>
                                    <input type="number" name="slj1" value="<?php echo $datarow['longJump1']; ?>" min="0" step="0.01" readonly>
                                </th>
                                <th><label for="slj2">Second Trial</label><br>
                                    <input type="number" name="slj2" value="<?php echo $datarow['longJump2']; ?>" min="0" step="0.01" readonly>
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
                                <th><label for="clockwise">Clockwise</label><br><input type="number" name="hexclock" value="<?php echo $datarow['hexagonClockwise']; ?>" min="0" readonly></th>
                                <th><label for="hexcounter">Counter Clockwise</label><br><input type="number" name="hexcounter" value="<?php echo $datarow['hexagonCounter']; ?>" min="0" readonly></th>
                                <th><label for="storkleft">Left Foot</label><br><input type="number" name="storkleft" value="<?php echo $datarow['storkLeft']; ?>" min="0" readonly>
                                </th>
                                <th><label for="storkright">Right Foot</label><br><input type="number" name="storkright" value="<?php echo $datarow['storkRight']; ?>" min="0" readonly>
                                </th>
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
                                <th><label for="stick1">First Trial</label><br><input type="number" name="stick1" value="<?php echo $datarow['stickDrop1']; ?>" step="0.01" min="0" max="30.48" readonly>
                                </th>
                                <th><label for="stick2">Second Trial</label><br><input type="number" name="stick2" value="<?php echo $datarow['stickDrop2']; ?>" step="0.01" min="0" max="30.48" readonly>
                                </th>
                                <th><label for="stick3">Third Trial</label><br><input type="number" name="stick3" value="<?php echo $datarow['stickDrop3']; ?>" step="0.01" min="0" max="30.48" readonly>
                                </th>
                            </tr>
                        </table>
                    </div>
                    <div class="section2">
                        <table class="health-related-test" id="tebla">
                            <tr>
                                <th>BODY COMPOSITION</th>
                                <th>CARDIOVASCULAR ENDURANCE</th>
                                <th>STRENGTH</th>
                                <th>FLEXIBILITY</th>
                                <th>REMARKS</th>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $datarow['bodyComposition']; ?>
                                </td>
                                <td>
                                    <?php echo $datarow['cardiovascularEndurance']; ?>
                                </td>
                                <td>
                                    <?php echo $datarow['strength']; ?>
                                </td>
                                <td>
                                    <?php echo $datarow['flexibility']; ?>
                                </td>
                                <td>
                                    <?php echo healthRemarks($datarow['bodyComposition'], $datarow['cardiovascularEndurance'], $datarow['strength'], $datarow['flexibility']); ?>
                                </td>
                            </tr>
                        </table>
                        <table class="skill-related-test" id="table">
                            <tr>
                                <th>COORDINATION</th>
                                <th>AGILITY</th>
                                <th>SPEED</th>
                                <th>POWER</th>
                                <th>BALANCE</th>
                                <th>REACTION TIME</th>
                                <th>REMARKS</th>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $datarow['coordination']; ?>
                                </td>
                                <td>
                                    <?php echo $datarow['agility']; ?>
                                </td>
                                <td>
                                    <?php echo $datarow['speed']; ?>
                                </td>
                                <td>
                                    <?php echo $datarow['power']; ?>
                                </td>
                                <td>
                                    <?php echo $datarow['balance']; ?>
                                </td>
                                <td>
                                    <?php echo $datarow['reactionTime']; ?>
                                </td>
                                <td>
                                    <?php echo skillRemarks($datarow['coordination'], $datarow['agility'], $datarow['speed'], $datarow['power'], $datarow['balance'], $datarow['reactionTime']); ?>
                                </td>
                            </tr>
                        </table>
                        <table class="physical-fitness-result" id="bleta">
                            <tr>
                                <th>FITNESS RESULT</th>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $datarow['fitnessResult']; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                }
            } else {
                ?>
                <div><img src="assets/nodata.png"></div>
            <?php
            }
            ?>
        </div>
    </div>
</body>
</html>