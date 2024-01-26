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
    if (empty($_SESSION["t_id"])) {
        header("Location: index.php");
    } else {
        $t_id = $_SESSION["t_id"];
        $hasStudents = false;
        $list = "SELECT * FROM `student` INNER JOIN `testdate` ON testdate.tdID = student.tdID";
        $studlist = mysqli_query($connection, $list);
        $syears = mysqli_query($connection, "SELECT * FROM `schoolyear` ORDER BY `year` DESC");
        $grade = mysqli_query($connection, "SELECT * FROM `gradesection` WHERE t_id = $t_id");
        $quarter = mysqli_query($connection, "SELECT * FROM `quarter`");
        $testtype = mysqli_query($connection, "SELECT * FROM `test`");
        if (isset($_POST["syear"])) {
            if (isset($_POST['syear']) && $_POST['syear'] != "") {
                $list .= " WHERE testdate.sy_id = '" . $_POST['syear'] . "'";
                mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["grade"])) {
            if (isset($_POST['grade']) && $_POST['grade'] != "") {
                $list .= " AND testdate.t_id = '" . $_POST['grade'] . "'";
                mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["quarter"])) {
            if (isset($_POST['quarter']) && $_POST['quarter'] != "") {
                $list .= " AND testdate.q_id = '" . $_POST['quarter'] . "'";
                mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["testtype"])) {
            if (isset($_POST['testtype']) && $_POST['testtype'] != "") {
                $list .= " AND testdate.testID = '" . $_POST['testtype'] . "'";
                mysqli_query($connection, $list);
            } else {
                $list .= " ";
            }
        }
        if (isset($_POST["sort"])) {
            switch ($_POST["sort"]) {
                case "name":
                    $list .= " ORDER BY `name`";
                    break;
                case "height":
                    $list .= " ORDER BY `height`";
                    break;
                case "weight":
                    $list .= " ORDER BY `weight`";
                    break;
                case "age":
                    $list .= " ORDER BY `age`";
                    break;
                default:
                    $list .= " ORDER BY `s_id`";
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
                                <option value='<?php echo $row1['sy_id'] ?>' <?php if (isset($_POST['syear']) && $_POST['syear'] === $row1['sy_id']) {
                                       echo 'selected';
                                   } ?>><?php echo $row1['year']; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <select name="grade" onchange="this.form.submit()">
                            <?php
                            while ($gs = mysqli_fetch_array($grade)) {
                                ?>
                                <option value='<?php echo $gs['t_id']; ?>' <?php if (isset($_POST['grade']) && $_POST['grade'] === $gs['t_id']) {
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
                                <option value='<?php echo $qtr['q_id']; ?>' <?php if (isset($_POST['quarter']) && $_POST['quarter'] === $qtr['q_id']) {
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
                                <option value='<?php echo $tt['testID']; ?>' <?php if (isset($_POST['testtype']) && $_POST['testtype'] === $tt['testID']) {
                                       echo 'selected';
                                   } ?>><?php echo $tt['testtype']; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <span>SORT BY</span>
                        <select name="sort" onchange="this.form.submit()">
                            <option>None</option>
                            <option value="name" <?php if (isset($_POST['sort']) && $_POST['sort'] === "name") {
                                echo 'selected';
                            } ?>>Name</option>
                            <option value="height" <?php if (isset($_POST['sort']) && $_POST['sort'] === "height") {
                                echo 'selected';
                            } ?>>Height</option>
                            <option value="weight" <?php if (isset($_POST['sort']) && $_POST['sort'] === "weight") {
                                echo 'selected';
                            } ?>>Weight</option>
                            <option value="age" <?php if (isset($_POST['sort']) && $_POST['sort'] === "age") {
                                echo 'selected';
                            } ?>>Age</option>
                        </select>
                    </form>
                    <input type="text" name="search" id="search" onkeyup="searchFunction()"
                        placeholder="Search Names...">
                    <a href="add.php"><button class="add-student">Add Student</button></a>
                </div>
            </div>

            <div>
                <table id="table" class="rounded-corners">
                    <tr>
                        <th>NAME</th>
                        <th>BIRTH DATE</th>
                        <th>HEIGHT (m)</th>
                        <th>WEIGHT (kg)</th>
                        <th>SEX</th>
                        <th>AGE</th>
                        <th>BMI</th>
                        <th>NUTRUTIONAL STATUS</th>
                        <th>HEIGHT-FOR-AGE</th>
                        <th>ACTION</th>
                    </tr>

                    <?php
                    while ($row = mysqli_fetch_assoc($studlist)) {
                        echo "<tr>";
                        echo "<td id='names'>{$row['name']}</td>";
                        echo "<td>{$row['birthdate']}</td>";
                        echo "<td>{$row['height']}</td>";
                        echo "<td>{$row['weight']}</td>";
                        echo "<td>{$row['sex']}</td>";
                        echo "<td>{$row['age']}</td>";
                        echo "<td>{$row['BMI']}</td>";
                        echo "<td>{$row['nutritional status']}</td>";
                        echo "<td>{$row['heightforage']}</td>";
                        echo "<td><a href='viewstudent.php?s_id={$row['s_id']}' target='_blank'></a>&nbsp;&nbsp;<a href='updatestudent.php?s_id={$row['s_id']}'><img class='action' src='assets/edit.png'></a>&nbsp;&nbsp;<a href='delete.php?s_id={$row['s_id']}'><img class='action' src='assets/delete.png'></a></td>";
                        echo "</tr>";
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