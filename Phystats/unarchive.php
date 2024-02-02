<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require 'config.php';
if (isset($_GET['teacher_ID'])) {
    if ($_GET['status'] === "Archived") {
    mysqli_query($connection, "UPDATE `teacher_tb` set `status` = 'Teaching' WHERE `teacher_ID` = '" . $_GET['teacher_ID'] . "'");
    } else if ($_GET['status'] === "Teaching") {
        echo '<script>alert("Teacher data is already Teaching!");</script>';
    }
    echo '<script>window.location.replace("manageTeachers.php");</script>';
}