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
</head>

<body>
    <?php
    include 'config.php';
    if (empty($_SESSION["teacher_ID"])) {
        header("Location: index.php");
    } else {
        $teacher_ID = $_SESSION["teacher_ID"];
        $student_ID = $_GET["student_ID"];
        $gradesql = mysqli_query($connection, "SELECT * FROM `studenttestdata_tb` INNER JOIN `gradesection_tb` ON gradesection_tb.grade_ID = studenttestdata_tb.grade_ID WHERE `student_ID` = '$student_ID'");
        $quartersql = mysqli_query($connection,"SELECT * FROM `studenttestdata_tb` INNER JOIN `testinfo_tb` ON testinfo_tb.testinfo_ID = studenttestdata_tb.testinfo_ID INNER JOIN `quarter_tb` ON quarter_tb.quarter_ID = testinfo_tb.quarter_ID WHERE `student_ID` = '$student_ID'");
        $sql = "SELECT * FROM `student_tb` INNER JOIN `studenttestdata_tb` ON studenttestdata_tb.student_ID = student_tb.student_ID WHERE student_tb.student_ID = '$student_ID'";
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
            <form method="POST">
                <select name="grade" onchange="this.form.submit()">
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
                <select name="quarter" onchange="this.form.submit()">
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
            </form>

        </div>
    </div>

</body>

</html>