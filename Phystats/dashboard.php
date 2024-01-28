<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Phystats - Dashboard</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.ico">
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/dashboard.css" />
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
    if (empty($_SESSION["principal_ID"])) {
        header("Location: index.php");
    } else {
        $principal_ID = $_SESSION["principal_ID"];
        $list = "SELECT COUNT(*) as `count` FROM `student_tb` INNER JOIN `studenttestdata_tb` ON studenttestdata_tb.student_ID = student_tb.student_ID INNER JOIN `testinfo_tb` ON testinfo_tb.testinfo_ID = studenttestdata_tb.testinfo_ID
         INNER JOIN `studenttestresult_tb` ON studenttestresult_tb.testdata_ID = studenttestdata_tb.testdata_ID INNER JOIN `teacher_tb` ON teacher_tb.teacher_ID = testinfo_tb.teacher_ID
         INNER JOIN `gradesection_tb` ON gradesection_tb.grade_ID = studenttestdata_tb.grade_ID INNER JOIN `principal_tb` ON principal_tb.principal_ID = teacher_tb.principal_ID WHERE principal_tb.principal_ID = $principal_ID";
        $overallstudents = mysqli_query($connection, $list);
        $fit = $list . " AND studenttestresult_tb.fitnessResult = 'Physically Fit'";
        $physfit = mysqli_query($connection, $fit);
        $notfit = $list . " AND studenttestresult_tb.fitnessResult = 'Not Physically Fit'";
        $notphysfit = mysqli_query($connection, $notfit);
        $syears = mysqli_query($connection, "SELECT * FROM `schoolyear_tb` ORDER BY `schoolYEAR` DESC");

        $grade6 = $list . " AND gradesection_tb.grade = 'Six'";
        $g6students = mysqli_query($connection, $grade6);
        $grade6fit = $grade6 . " AND studenttestresult_tb.fitnessResult = 'Physically Fit'";
        $g6fit = mysqli_query($connection, $grade6fit);
        $grade6notfit = $grade6 . " AND studenttestresult_tb.fitnessResult = 'Not Physically Fit'";
        $g6notfit = mysqli_query($connection, $grade6notfit);

        $grade5 = $list . " AND gradesection_tb.grade = 'Five'";
        $g5students = mysqli_query($connection, $grade5);
        $grade5fit = $grade5 . " AND studenttestresult_tb.fitnessResult = 'Physically Fit'";
        $g5fit = mysqli_query($connection, $grade5fit);
        $grade5notfit = $grade5 . " AND studenttestresult_tb.fitnessResult = 'Not Physically Fit'";
        $g5notfit = mysqli_query($connection, $grade5notfit);

        $grade4 = $list . " AND gradesection_tb.grade = 'Four'";
        $g4students = mysqli_query($connection, $grade4);
        $grade4fit = $grade4 . " AND studenttestresult_tb.fitnessResult = 'Physically Fit'";
        $g4fit = mysqli_query($connection, $grade4fit);
        $grade4notfit = $grade4 . " AND studenttestresult_tb.fitnessResult = 'Not Physically Fit'";
        $g4notfit = mysqli_query($connection, $grade4notfit);

        $grade6sections = mysqli_query($connection, "SELECT `section` FROM `gradesection_tb` WHERE `grade` = 'Six'");
        $grade5sections = mysqli_query($connection, "SELECT `section` FROM `gradesection_tb` WHERE `grade` = 'Five'");
        $grade4sections = mysqli_query($connection, "SELECT `section` FROM `gradesection_tb` WHERE `grade` = 'Four'");
        if (isset($_POST['syear'])) {
            if (isset($_POST['syear']) && $_POST['syear'] != "") {
                $list .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $overallstudents = mysqli_query($connection, $list);
                $fit  .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $physfit = mysqli_query($connection, $fit);
                $notfit  .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $notphysfit = mysqli_query($connection, $notfit);

                $grade6 .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $g6students = mysqli_query($connection, $grade6);
                $grade6fit .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $g6fit = mysqli_query($connection, $grade6fit);
                $grade6notfit .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $g6notfit = mysqli_query($connection, $grade6notfit);

                $grade5 .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $g5students = mysqli_query($connection, $grade5);
                $grade5fit .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $g5fit = mysqli_query($connection, $grade5fit);
                $grade5notfit .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $g5notfit = mysqli_query($connection, $grade5notfit);

                $grade4 .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $g4students = mysqli_query($connection, $grade4);
                $grade4fit .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $g4fit = mysqli_query($connection, $grade4fit);
                $grade4notfit .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $g4notfit = mysqli_query($connection, $grade4notfit);
            } else {
                $list .= " ";
                $fit .= " ";
                $notfit .= " ";
                $grade6 .= " ";
                $grade6fit .= " ";
                $grade6notfit .= " ";
                $grade5 .= " ";
                $grade5fit .= " ";
                $grade5notfit .= " ";
                $grade4 .= " ";
                $grade4fit .= " ";
                $grade4notfit .= " ";
            }
        }
        if (isset($_POST['section6'])) {
            if (isset($_POST['section6']) && $_POST['section6'] != "") {
                $grade6 .= " AND gradesection_tb.section = '" . $_POST['section6'] . "'";
                $g6students = mysqli_query($connection, $grade6);
                $grade6fit .= " AND gradesection_tb.section = '" . $_POST['section6'] . "'";
                $g6fit = mysqli_query($connection, $grade6fit);
                $grade6notfit .= " AND gradesection_tb.section = '" . $_POST['section6'] . "'";
                $g6notfit = mysqli_query($connection, $grade6notfit);
            } else {
                $grade6 .= " ";
                $grade6fit .= " ";
                $grade6notfit .= " ";
            }
        }
        if (isset($_POST['section5'])) {
            if (isset($_POST['section5']) && $_POST['section5'] != "") {
                $grade5 .= " AND gradesection_tb.section = '" . $_POST['section5'] . "'";
                $g5students = mysqli_query($connection, $grade5);
                $grade5fit .= " AND gradesection_tb.section = '" . $_POST['section5'] . "'";
                $g5fit = mysqli_query($connection, $grade5fit);
                $grade5notfit .= " AND gradesection_tb.section = '" . $_POST['section5'] . "'";
                $g5notfit = mysqli_query($connection, $grade5notfit);
            } else {
                $grade5 .= " ";
                $grade5fit .= " ";
                $grade5notfit .= " ";
            }
        }
        if (isset($_POST['section4'])) {
            if (isset($_POST['section4']) && $_POST['section4'] != "") {
                $grade4 .= " AND gradesection_tb.section = '" . $_POST['section4'] . "'";
                $g4students = mysqli_query($connection, $grade4);
                $grade4fit .= " AND gradesection_tb.section = '" . $_POST['section4'] . "'";
                $g4fit = mysqli_query($connection, $grade4fit);
                $grade4notfit .= " AND gradesection_tb.section = '" . $_POST['section4'] . "'";
                $g4notfit = mysqli_query($connection, $grade4notfit);
            } else {
                $grade4 .= " ";
                $grade4fit .= " ";
                $grade4notfit .= " ";
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
            <a href="dashboard.php" class="here nav-options">DASHBOARD</a>
            <a href="#" class="nav-options">MANAGE</a>
            <a href="#" class="nav-options"><img class="profile" src="assets/wprof.png"></a>
        </div>
    </nav>

    <div class="content">
        <form method="POST">
            <select name="syear" onchange="this.form.submit()" style="float:right;">
                <option value="">School Year (All)</option>
                <?php
                while ($row1 = mysqli_fetch_assoc($syears)) {
                ?>
                    <option value='<?php echo $row1['schoolyear_ID'] ?>' <?php if (isset($_POST['syear']) && $_POST['syear'] === $row1['schoolyear_ID']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $row1['schoolYEAR']; ?></option>
                <?php
                }
                ?>
            </select>
            <div class="container">
                <h1>OVERALL</h1>
                <div class="sections">
                    <div class="counts">
                        <h2>No. of Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($overallstudents)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                    <div class="counts">
                        <h2>No. of Physically Fit Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($physfit)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                    <div class="counts">
                        <h2>No. of Not Physically Fit Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($notphysfit)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                </div>
            </div>
            <div class="container">
                <select name="section6" onchange="this.form.submit()" style="float:right;">
                    <option value="">Section (All)</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($grade6sections)) {
                    ?>
                        <option value='<?php echo $row['section'] ?>' <?php if (isset($_POST['section6']) && $_POST['section6'] === $row['section']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $row['section']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <h1>Grade 6</h1>
                <div class="sections">
                    <div class="counts">
                        <h2>No. of Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($g6students)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                    <div class="counts">
                        <h2>No. of Physically Fit Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($g6fit)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                    <div class="counts">
                        <h2>No. of Not Physically Fit Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($g6notfit)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                </div>
            </div>
            <div class="container">
                <select name="section5" onchange="this.form.submit()" style="float:right;">
                    <option value="">Section (All)</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($grade5sections)) {
                    ?>
                        <option value='<?php echo $row['section'] ?>' <?php if (isset($_POST['section5']) && $_POST['section5'] === $row['section']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $row['section']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <h1>Grade 5</h1>
                <div class="sections">
                    <div class="counts">
                        <h2>No. of Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($g5students)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                    <div class="counts">
                        <h2>No. of Physically Fit Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($g5fit)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                    <div class="counts">
                        <h2>No. of Not Physically Fit Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($g5notfit)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                </div>
            </div>
            <div class="container">
                <select name="section4" onchange="this.form.submit()" style="float:right;">
                    <option value="">Section (All)</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($grade4sections)) {
                    ?>
                        <option value='<?php echo $row['section'] ?>' <?php if (isset($_POST['section4']) && $_POST['section4'] === $row['section']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $row['section']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <h1>Grade 4</h1>
                <div class="sections">
                    <div class="counts">
                        <h2>No. of Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($g4students)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                    <div class="counts">
                        <h2>No. of Physically Fit Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($g4fit)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                    <div class="counts">
                        <h2>No. of Not Physically Fit Students</h2>
                        <h1><?php while ($row = mysqli_fetch_assoc($g4notfit)) {
                                echo $row["count"];
                            } ?></h1>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>