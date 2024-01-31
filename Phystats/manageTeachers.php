<?php session_start() ?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Manage Teachers - Phystats </title>
        <link rel="icon" type="image/x-icon" href="assets/logo.ico">
        <link rel="stylesheet" href="css/nav.css"/>
        <link rel="stylesheet" href="css/admin-manage.css"/>
    </head>
    <body>
        <nav>
            <div>
                <img class="logo" src="assets/wlogo.png">
                <h1 class="title">Phystats</h1>
            </div>
            <div>
                <a href="dashboard.php" class="here nav-options">DASHBOARD</a>
                <div class="nav-options">
                    <span class="manage">MANAGE</span>
                    <div class="dropdown">
                        <a href="manageTeachers.php">Manage Teachers</a>
                        <a href="#"><button onclick="openAddSchoolYear()">Add School Year</button></a>
                    </div>
                </div>
                <a href="adminProfile.php" class="nav-options"><img class="profile" src="assets/wprof.png"></a>
            </div>
        </nav>

        <!-- "Automation" lmao -->
        <main>
            <h1 id="page-header"> Manage Teachers </h1>

            <h1> GRADE SIX </h1>
            <table class="data-display" id="g6-teachers">
                <tr>
                    <th style="width: 10%;"> No. </th>
                    <th style="width: 30%;"> Name </th>
                    <th style="width: 30%;"> Email </th>
                    <th style="width: 30%;"> Section </th>
                </tr>
                <?php echo retrieveTeachersFromGrade("Six") ?>
            </table>
            <h1> GRADE FIVE </h1>
            <table class="data-display" id="g5-teachers">
                <tr>
                    <th style="width: 10%;"> No. </th>
                    <th style="width: 30%;"> Name </th>
                    <th style="width: 30%;"> Email </th>
                    <th style="width: 30%;"> Section </th>
                </tr>
                <?php echo retrieveTeachersFromGrade("Five") ?>
            </table>
            <h1> GRADE FOUR </h1>
            <table class="data-display" id="g4-teachers">
                <tr>
                    <th style="width: 10%;"> No. </th>
                    <th style="width: 30%;"> Name </th>
                    <th style="width: 30%;"> Email </th>
                    <th style="width: 30%;"> Section </th>
                </tr>
                <?php echo retrieveTeachersFromGrade("Four") ?>
            </table>
        </main>
    </body>
</html>


<?php 
    function retrieveTeachersFromGrade($grade) {
        $entry_number = 1;
        $data_sheet = "";
        $DB_CONNECTION = mysqli_connect("localhost", "root", "", "phystats");
        $SQL_QUERY = "SELECT t.teacher_ID, CONCAT_WS(' ', t.teacher_FNAME, t.teacher_LNAME) AS teacher_name, t.teacher_EMAIL AS email, g.section AS section
                      FROM teacher_tb AS t, gradesection_tb AS g 
                      WHERE g.grade=\"".$grade."\" AND g.teacher_ID=t.teacher_ID AND t.teacher_ID=g.teacher_ID;";
        $RESULT_SET = mysqli_query($DB_CONNECTION, $SQL_QUERY);

        while( $data = mysqli_fetch_row($RESULT_SET) ) {
            $data_sheet .= "<tr>
                                <td> ".$entry_number." </td>
                                <td> ".$data[1]." </td>
                                <td> ".$data[2]." </td>
                                <td> ".$data[3]." </td>
                            </tr>
                            ";
            $entry_number++;
        }

        if ($data_sheet == "") {
            $data_sheet .= "<tr>
                                <td class='none' colspan=5 style=\"font-size: 30px; padding: 25px 0px 25px 0px\">No Teachers in this Grade Level</td>
                            <tr>";
            return $data_sheet;
        } else {
            return $data_sheet;
        }
    }
?> 