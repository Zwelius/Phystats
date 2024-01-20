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
        $studlist = mysqli_query($connection, "SELECT * FROM `student` INNER JOIN `testdate` ON testdate.tdID = student.tdID WHERE testdate.t_id = $t_id");
        $syears = mysqli_query($connection, "SELECT * FROM `schoolyear` ORDER BY `year` DESC");
        $grade = mysqli_query($connection, "SELECT * FROM `gradesection` WHERE t_id = $t_id");
        $quarter = mysqli_query($connection, "SELECT * FROM `quarter`");
        $testtype = mysqli_query($connection, "SELECT * FROM `test`");
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
                    <select name="syear">
                        <option value="">SCHOOL YEAR</option>
                        <?php
                        while ($row1 = mysqli_fetch_array($syears)) {
                            echo "<option value='" . $row1['sy_id'] . "'>" . $row1['year'] . "</option>";
                        }
                        ?>
                    </select>
                    <select name="grade">
                        <?php
                        while ($gs = mysqli_fetch_array($grade)) {
                            echo "<option value='" . $gs['t_id'] . "'>" . $gs['grade'] . " - " . $gs['section'] . "</option>";
                        }
                        ?>
                    </select>
                    <select name="quarter">
                        <?php
                        while ($qtr = mysqli_fetch_array($quarter)) {
                            echo "<option value='" . $qtr['q_id'] . "'>" . $qtr['quarter'] . "</option>";
                        }
                        ?>
                    </select>
                    <select name="testtype">
                        <?php
                        while ($tt = mysqli_fetch_array($testtype)) {
                            echo "<option value='" . $tt['testID'] . "'>" . $tt['testtype'] . "</option>";
                        }
                        ?>
                    </select>

                    <input type="text" name="search" id="search" onkeyup="searchFunction()"
                        placeholder="Search Names...">

                    <div>
                        <span>SORT BY</span>
                        <select>
                            <option>Name</option>
                            <option>Height</option>
                            <option>Weight</option>
                            <option>Age</option>
                        </select>
                    </div>
                    <a href="add.php"><button class="add-student">Add Student</button></a>
                </div>
            </div>

            <div>

                <table class="rounded-corners">
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
                        echo "<td><a href='viewstudent.php?s_id={$row['s_id']}' target='_blank'><img class='action' src='assets/view.png'></a>&nbsp;&nbsp;<a href='updatestudent.php?s_id={$row['s_id']}'><img class='action' src='assets/edit.png'></a>&nbsp;&nbsp;<a href='delete.php?s_id={$row['s_id']}'><img class='action' src='assets/delete.png'></a></td>";
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
    <script type="text/javascript" src="/js/script.js"></script>
</body>

</html>