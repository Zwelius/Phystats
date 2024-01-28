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
    <title>Phystats - Student List</title>
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/list.css" />
    <script type="text/javascript" src="js/script.js"></script>
    <style>
        img.action {
            width: 17px;
            vertical-align: central;
        }

        td.none {
            height: 40px;
            font-size: 24pt;
        }
    </style>
</head>

<body>
    <?php
    include 'config.php';
    if (empty($_SESSION["teacher_ID"])) {
        header("Location: index.php");
    } else {
        $teacher_ID = $_SESSION["teacher_ID"];
        $hasStudents = false;
        $list = "SELECT * FROM `student_tb` INNER JOIN `studenttestdata_tb` ON studenttestdata_tb.student_ID = student_tb.student_ID INNER JOIN `testinfo_tb` ON testinfo_tb.testinfo_ID = studenttestdata_tb.testinfo_ID WHERE testinfo_tb.teacher_ID = '$teacher_ID'";
        $studlist = mysqli_query($connection, $list);
        $syears = mysqli_query($connection, "SELECT * FROM `schoolyear_tb` ORDER BY `schoolYEAR` DESC");
        $grade = mysqli_query($connection, "SELECT * FROM `gradesection_tb` INNER JOIN `teacher_tb` ON teacher_tb.teacher_ID = gradesection_tb.teacher_ID WHERE gradesection_tb.teacher_ID = $teacher_ID");
        $quarter = mysqli_query($connection, "SELECT * FROM `quarter_tb`");
        $testtype = mysqli_query($connection, "SELECT * FROM `testtype_tb`");
        if (isset($_POST["syear"])) {
            if (isset($_POST['syear']) && $_POST['syear'] != "") {
                $list .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["grade"])) {
            if (isset($_POST['grade']) && $_POST['grade'] != "") {
                $list .= " AND studenttestdata_tb.grade_ID = '" . $_POST['grade'] . "'";
                mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["quarter"])) {
            if (isset($_POST['quarter']) && $_POST['quarter'] != "") {
                $list .= " AND testinfo_tb.quarter_ID = '" . $_POST['quarter'] . "'";
                mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["testtype"])) {
            if (isset($_POST['testtype']) && $_POST['testtype'] != "") {
                $list .= " AND testinfo_tb.testtype_ID = '" . $_POST['testtype'] . "'";
                mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["sort"])) {
            switch ($_POST["sort"]) {
                case "name":
                    $list .= " ORDER BY `studentNAME`";
                    break;
                case "sex":
                    $list .= " ORDER BY `studentSEX`";
                    break;
                case "bday":
                    $list .= " ORDER BY `studentBIRTHDATE`";
                    break;
            }
            $studlist = mysqli_query($connection, $list);
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
                        <span>SORT BY</span>
                        <select name="sort" onchange="this.form.submit()">
                            <option value="">Date Added</option>
                            <option value="name" <?php if (isset($_POST['sort']) && $_POST['sort'] === "name") {
                                echo 'selected';
                            } ?>>Name</option>
                            <option value="sex" <?php if (isset($_POST['sort']) && $_POST['sort'] === "sex") {
                                echo 'selected';
                            } ?>>Sex</option>
                            <option value="bday" <?php if (isset($_POST['sort']) && $_POST['sort'] === "bday") {
                                echo 'selected';
                            } ?>>Birth Date</option>
                        </select>
                    </form>
                    <input type="text" name="search" id="search" onkeyup="searchFunction()"
                        placeholder="Search Names...">
                    <a href="add.php"><button class="add-student">Add Student</button></a>
                </div>
            </div>

            <div>
                <table class="list-table">
                    <tr">
                        <th>NAME</th>
                        <th>BIRTH DATE</th>
                        <th>SEX</th>

                    <?php
                    while ($row = mysqli_fetch_assoc($studlist)) {
                        ?>
                        <tr onclick="window.open('viewstudent.php?student_ID=<?php echo $row['student_ID'];?>', '_blank');">
                        <td id='names'><?php echo $row['studentNAME']; ?></td>
                        <td><?php echo $row['studentBIRTHDATE']; ?></td>
                        <td><?php echo $row['studentSEX']; ?></td>
                        <!--echo "<td><a href='viewstudent.php?student_ID={$row['student_ID']}' target='_blank'></a>&nbsp;&nbsp;<a href='updatestudent.php?student_ID={$row['student_ID']}'><img class='action' src='assets/edit.png'></a>&nbsp;&nbsp;<a href='delete.php?student_ID={$row['student_ID']}'><img class='action' src='assets/delete.png'></a></td>";
                    --></tr>
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