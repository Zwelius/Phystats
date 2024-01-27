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
    <title>Phystats - Test Results</title>
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/result.css" />
    <script type="text/javascript" src="js/script.js"></script>
</head>

<body>
    <?php
    include 'config.php';
    if (empty($_SESSION["teacher_ID"])) {
        header("Location: index.php");
    } else {
        $teacher_ID = $_SESSION["teacher_ID"];
        $hasStudents = false;
        $list = "SELECT * FROM `student_tb` INNER JOIN `studenttestdata_tb` ON studenttestdata_tb.student_ID = student_tb.student_ID INNER JOIN `testinfo_tb` ON testinfo_tb.testinfo_ID = studenttestdata_tb.testinfo_ID INNER JOIN `studenttestresult_tb` ON studenttestresult_tb.testdata_ID = studenttestdata_tb.testdata_ID WHERE testinfo_tb.teacher_ID = '$teacher_ID'";
        $studlist1 = mysqli_query($connection, $list);
        $studlist2 = mysqli_query($connection, $list);
        $studlist3 = mysqli_query($connection, $list);
        $syears = mysqli_query($connection, "SELECT * FROM `schoolyear_tb` ORDER BY `schoolYEAR` DESC");
        $grade = mysqli_query($connection, "SELECT * FROM `gradesection_tb` WHERE `teacher_ID` = $teacher_ID");
        $quarter = mysqli_query($connection, "SELECT * FROM `quarter_tb`");
        $testtype = mysqli_query($connection, "SELECT * FROM `testtype_tb`");
        if (isset($_POST["syear"])) {
            if (isset($_POST['syear']) && $_POST['syear'] != "") {
                $list .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $studlist1 = mysqli_query($connection, $list);
                $studlist2 = mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["grade"])) {
            if (isset($_POST['grade']) && $_POST['grade'] != "") {
                $list .= " AND studenttestdata_tb.grade_ID = '" . $_POST['grade'] . "'";
                $studlist1 = mysqli_query($connection, $list);
                $studlist2 = mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["quarter"])) {
            if (isset($_POST['quarter']) && $_POST['quarter'] != "") {
                $list .= " AND testinfo_tb.quarter_ID = '" . $_POST['quarter'] . "'";
                $studlist1 = mysqli_query($connection, $list);
                $studlist2 = mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["testtype"])) {
            if (isset($_POST['testtype']) && $_POST['testtype'] != "") {
                $list .= " AND testinfo_tb.testtype_ID = '" . $_POST['testtype'] . "'";
                $studlist1 = mysqli_query($connection, $list);
                $studlist2 = mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
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
            <a href="result.php" class="here nav-options">TEST RESULTS</a>
            <a href="profile.php" class="nav-options"><img class="profile" src="assets/wprof.png"></a>
        </div>
    </nav>

    <section class="content">
        <div class="student-list">
            <div class="filter-content">
                <div class="filter">
                    <form method="POST">
                        <select name="syear" onchange="this.form.submit()">
                            <option value="">School Year (All)</option>
                            <?php
                            while ($row1 = mysqli_fetch_array($syears)) {
                                ?>
                                <option value='<?php echo $row1['schoolyear_ID'] ?>' <?php if (isset($_POST['syear']) && $_POST['syear'] === $row1['schoolyear_ID']) {
                                       echo 'selected';
                                   } ?>><?php echo $row1['schoolYEAR']; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <select name="grade" onchange="this.form.submit()">
                            <?php
                            while ($gs = mysqli_fetch_array($grade)) {
                                ?>
                                <option value='<?php echo $gs['grade_ID']; ?>' <?php if (isset($_POST['grade']) && $_POST['grade'] === $gs['grade_ID']) {
                                       echo 'selected';
                                   } ?>><?php echo $gs['grade'] . " - " . $gs['section']; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <select name="quarter" onchange="this.form.submit()">
                            <option value="">Quarter (All)</option>
                            <?php
                            while ($qtr = mysqli_fetch_array($quarter)) {
                                ?>
                                <option value='<?php echo $qtr['quarter_ID']; ?>' <?php if (isset($_POST['quarter']) && $_POST['quarter'] === $qtr['quarter_ID']) {
                                       echo 'selected';
                                   } ?>><?php echo $qtr['quarter']; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <select name="testtype" onchange="this.form.submit()">
                            <option value="">Test Type (All)</option>
                            <?php
                            while ($tt = mysqli_fetch_array($testtype)) {
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
                    <input type="text" id="search" onkeyup="searchFunction(), searchFunction2()"
                        placeholder="Search Names...">

                </div>
            </div>

            <div class="tab-container">
                <input type="radio" id="health-related-test" name="tab-container" checked="checked">
                <label for="health-related-test">Health-Related</label>
                <!-----health-related test results----->
                <div class="tab">
                    <table class="health-related-test" id="tebla">
                        <tr>
                            <th>NAME</th>
                            <th>BODY COMPOSITION</th>
                            <th>CARDIOVASCULAR ENDURANCE</th>
                            <th>STRENGTH</th>
                            <th>FLEXIBILITY</th>
                        </tr>

                        <?php
                        while ($row = mysqli_fetch_assoc($studlist1)) {
                            ?>
                        <tr>
                            <td>
                                <?php echo $row['studentNAME']; ?>
                            </td>
                            <td>
                                <?php echo $row['bodyComposition']; ?>
                            </td>
                            <td>
                                <?php echo $row['cardiovascularEndurance']; ?>
                            </td>
                            <td>
                                <?php echo $row['strength']; ?>
                            </td>
                            <td>
                                <?php echo $row['flexibility']; ?>
                            </td>
                        </tr>
                        <?php
                        $hasStudents = true;
                        }

                        if (!$hasStudents) {
                            echo "<tr>";
                            echo "<td class='none' colspan=10>No Students Found</td>";
                            echo "<tr>";
                        }
                        ?>
                    </table>
                </div>

                <!-----skill-related test results----->
                <input type="radio" id="skill-related-test" name="tab-container">
                <label for="skill-related-test">Skill-Related</label>
                <div class="tab">
                    <table class="skill-related-test" id="table">
                        <tr>
                            <th>NAME</th>
                            <th>COORDINATION</th>
                            <th>AGILITY</th>
                            <th>SPEED</th>
                            <th>POWER</th>
                            <th>BALANCE</th>
                            <th>REACTION TIME</th>
                        </tr>

                        <?php
                        while ($row2 = mysqli_fetch_assoc($studlist2)) {
                            ?>
                        <tr>
                            <td>
                                <?php echo $row2['studentNAME']; ?>
                            </td>
                            <td>
                                <?php echo $row2['coordination']; ?>
                            </td>
                            <td>
                                <?php echo $row2['agility']; ?>
                            </td>
                            <td>
                                <?php echo $row2['speed']; ?>
                            </td>
                            <td>
                                <?php echo $row2['power']; ?>
                            </td>
                            <td>
                                <?php echo $row2['balance']; ?>
                            </td>
                            <td>
                                <?php echo $row2['reactionTime']; ?>
                            </td>
                        </tr>
                        <?php
                        $hasStudents = true;
                        }
                        if (!$hasStudents) {
                            echo "<tr>";
                            echo "<td class='none' colspan=10>No Students Found</td>";
                            echo "<tr>";
                        }
                        ?>
                    </table>
                </div>
                <input type="radio" id="physical-fitness-result" name="tab-container">
                <label for="physical-fitness-result">Physical Fitness Result</label>
                <!-----overall test results----->
                <div class="tab">
                    <table class="physical-fitness-result" id="bleta">
                        <tr>
                            <th>NAME</th>
                            <th>FITNESS RESULT</th>
                        </tr>
                        <?php
                        while ($row2 = mysqli_fetch_assoc($studlist3)) {
                            ?>
                        <tr>
                            <td>
                                <?php echo $row2['studentNAME']; ?>
                            </td>
                            <td>
                                <?php echo $row2['fitnessResult']; ?>
                            </td>
                        </tr>
                        <?php
                        $hasStudents = true;
                        }
                        if (!$hasStudents) {
                            echo "<tr>";
                            echo "<td class='none' colspan=10>No Students Found</td>";
                            echo "<tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
    </section>
</body>

</html>