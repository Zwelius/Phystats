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
    <link rel="stylesheet" href="css/list.css" />
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
            <a href="list.php" class="nav-options">STUDENT LIST</a>
            <a href="result.php" class="here nav-options">TEST RESULTS</a>
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

                    <input type="text" id="search" onkeyup="searchFunction()" placeholder="Search Names...">

                </div>
            </div>

            <div>
                <table class="rounded-corners">
                    <tr>
                        <th>NAME</th>
                        <th>BODY COMPOSITION</th>
                        <th>CARDIOVASCULAR ENDURANCE</th>
                        <th>STRENGTH</th>
                        <th>FLEXIBILITY</th>
                        <th>COORDINATION</th>
                        <th>AGILITY</th>
                        <th>SPEED</th>
                        <th>POWER</th>
                        <th>BALANCE</th>
                        <th>REACTION TIME</th>
                        <th>FITNESS RESULT</th>
                    </tr>

                    <?php
                    while ($row = mysqli_fetch_assoc($studlist)) {
                        echo "<tr>";
                        echo "<td>{$row['name']}</td>";
                        //echo "<td>{$row['bodyComposition']}</td>";
                        //echo "<td>{$row['cardiovascularEndurance']}</td>";
                       // echo "<td>{$row['strength']}</td>";
                        //echo "<td>{$row['flexibility']}</td>";
                        //echo "<td>{$row['age']}</td>";
                        //echo "<td>{$row['BMI']}</td>";
                        //echo "<td>{$row['nutritional status']}</td>";
                        //echo "<td>{$row['heightforage']}</td>";
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