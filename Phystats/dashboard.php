<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Phystats - Dashboard</title>
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
    if (empty($_SESSION["p_id"])) {
        header("Location: index.php");
    } else {
        $p_id = $_SESSION["p_id"];
        $list = "SELECT COUNT(*) FROM `student` INNER JOIN `testdate` ON testdate.tdID = student.tdID INNER JOIN `testresult` ON testresult.s_id = student.s_id INNER JOIN resultinterpretation ON resultinterpretation.tr_ID = testresult.tr_ID INNER JOIN `teacher` ON testdate.t_id = teacher.t_id INNER JOIN `principal` ON teacher.p_id = principal.p_id";
        $overallstudents = mysqli_query($connection, $list);
        $syears = mysqli_query($connection, "SELECT * FROM `schoolyear` ORDER BY `year` DESC");
        
        if (isset($_POST["syear"])) {
            if (isset($_POST['syear']) && $_POST['syear'] != "") {
                $list .= " WHERE testdate.sy_id = '" . $_POST['syear'] . "'";
                mysqli_query($connection, $list);
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
            <a href="#" class="nav-options">STUDENT PERFORMANCE</a>
            <a href="#" class="nav-options">MANAGE</a>
            <a href="#" class="nav-options"><img class="profile" src="assets/wprof.png"></a>
        </div>
    </nav>

    <div class="content">
        <select name="syear" onchange="this.form.submit()">
            <option value="">School Year (All)</option>
            <?php
            while ($row1 = mysqli_fetch_array($syears)) {
            ?>
                <option value='<?php echo $row1['sy_id'] ?>' <?php if (isset($_POST['syear']) && $_POST['syear'] === $row1['sy_id']) {echo 'selected';} ?>><?php echo $row1['year']; ?></option>
            <?php
            }
            ?>
        </select>
        <div>
            <h1>Overall Students</h1>
            <div>
                <?php $stfs = mysqli_fetch_row($overallstudents); echo $stfs[0];?>
            </div>
        </div>
    </div>
</body>

</html>