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
        $list = "SELECT COUNT(*) as `count` FROM `student_tb` INNER JOIN `studenttestdata_tb` ON studenttestdata_tb.student_ID = student_tb.student_ID INNER JOIN `testinfo_tb` ON testinfo_tb.testinfo_ID = studenttestdata_tb.testinfo_ID INNER JOIN `studenttestresult_tb` ON studenttestresult_tb.testdata_ID = studenttestdata_tb.testdata_ID INNER JOIN `teacher_tb` ON teacher_tb.teacher_ID = testinfo_tb.teacher_ID INNER JOIN `principal_tb` ON principal_tb.principal_ID = teacher_tb.principal_ID";
        $overallstudents = mysqli_query($connection, $list);
        $fit = $list . " WHERE studenttestresult_tb.fitnessResult = 'Physically Fit'";
        $physfit = mysqli_query($connection, $fit);
        $notfit = $list . " WHERE studenttestresult_tb.fitnessResult = 'Not Physically Fit'";
        $notphysfit = mysqli_query($connection, $notfit);
        $syears = mysqli_query($connection, "SELECT * FROM `schoolyear_tb` ORDER BY `schoolYEAR` DESC");

        if (isset($_POST['syear'])) {
            if (isset($_POST['syear']) && $_POST['syear'] != "") {
                $list .= " WHERE testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $fit  .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $notfit  .= " AND testinfo_tb.schoolyear_ID = '" . $_POST['syear'] . "'";
                $overallstudents = mysqli_query($connection, $list);
                $physfit = mysqli_query($connection, $fit);
                $notphysfit = mysqli_query($connection, $notfit);
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
        </form>
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
    </div>
</body>

</html>