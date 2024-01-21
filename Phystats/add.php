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
            $tr_ID = mysqli_insert_id($connection);
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
            mysqli_query($connection, "INSERT INTO `resultinterpretation`(`tr_ID`, `bodyComposition`, `cardiovascularEndurance`, `strength`, `flexibility`, `coordination`, `agility`, `speed`, `power`, `balance`, `reactionTime`, `fitnessResult`) VALUES ($tr_ID, '$bodyComposition', '$cardiovascularEndurance', '$strength', '$flexibility', '$coordination', '$agility', '$speed', '$power', '$balance', '$reactionTime', '$fitnessResult')");
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

    <div class="add-form">
        <form method="POST">
            <p>Physical Fitness Test</p>
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
                            <th colspan="2"><select name="syear">
                                    <?php
                                    while ($row1 = mysqli_fetch_array($syears)) {
                                        echo "<option value='" . $row1['sy_id'] . "'>" . $row1['year'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </th>

                            <th colspan="2"><select name="quarter">
                                    <?php
                                    while ($qtr = mysqli_fetch_array($quarter)) {
                                        echo "<option value='" . $qtr['q_id'] . "'>" . $qtr['quarter'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </th>
                            <th colspan="2"><select name="testtype">
                                    <?php
                                    while ($tt = mysqli_fetch_array($testtype)) {
                                        echo "<option value='" . $tt['testID'] . "'>" . $tt['testtype'] . "</option>";
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
                            <th colspan="6"><input type="text" name="name" required></th>
                            <th colspan="2">&nbsp;</th><!--empty-->
                            <th>
                                <select name="nutritionalstatus">
                                    <option value="Severely Wasted">Severely Wasted</option>
                                    <option value="Wasted">Wasted</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Overweight">Overweight</option>
                                    <option value="Obese">Obese</option>
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
                            <th colspan="2"><input type="date" name="bday" required></th>
                            <th colspan="2">
                                <select name="sex">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </th>
                            <th colspan="2">
                                <input type="number" name="age" required>
                            </th>
                            <th colspan="2">&nbsp;</th><!--empty-->
                            <th colspan="2">
                                <select name="heightforage">
                                    <option value="Severely Stunted">Severely Stunted</option>
                                    <option value="Stunted">Stunted</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Tall">Tall</option>
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
                            <th colspan="2"><input type="number" name="height" step="0.01" required></th>
                            <th colspan="2"><input type="number" name="weight" step="0.01" required></th>
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
                                    step="0.01" required></th>
                            <th><label for="HRafter">After Activity</label><br><input type="number" name="HRafter"
                                    step="0.01" required></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th><label for="zipperL">Left</label><br> <input type="number" name="zipperL" step="0.01"
                                    required></th>
                            <th><label for="zipperR">Right</label><br><input type="number" name="zipperR" step="0.01"
                                    required></th>
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
                                    required></th>
                            <th><label for="plank">BASIC PLANK (sec)</label><br><input type="number" name="plank"
                                    required></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th><label for="sar1">First Trial</label><br><input type="number" name="sar1" step="0.01"
                                    required></th>
                            <th><label for="sar2">Second Trial</label><br><input type="number" name="sar2" step="0.01"
                                    required></th>
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
                                    required></th>
                            <th colspan="4">&nbsp;</th><!--empty-->
                            <th><label for="slj1">First Trial</label><br>
                                <input type="number" name="slj1" step="0.01" required>
                            </th>
                            <th><label for="slj2">Second Trial</label><br>
                                <input type="number" name="slj2" step="0.01" required>
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
                                    required></th>
                            <th><label for="hexcounter">Counter Clockwise</label><br><input type="number"
                                    name="hexcounter" required></th>
                            <th colspan="3">&nbsp;</th><!--empty-->
                            <th><label for="storkleft">Left Foot</label><br><input type="number" name="storkleft"
                                    required>
                            </th>
                            <th><label for="storkright">Right Foot</label><br><input type="number" name="storkright"
                                    required>
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
                                    name="sprinttime" step="0.01" required>
                            </th>
                            <th colspan="4">&nbsp;</th><!--empty-->
                            <th><label for="stick1">First Trial</label><br><input type="number" name="stick1"
                                    step="0.01" required>
                            </th>
                            <th><label for="stick2">Second Trial</label><br><input type="number" name="stick2"
                                    step="0.01" required>
                            </th>
                            <th><label for="stick3">Third Trial</label><br><input type="number" name="stick3"
                                    step="0.01" required>
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