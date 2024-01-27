<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require 'config.php';
if (isset($_GET['student_ID'])) {
    mysqli_query($connection, "DELETE FROM `student_tb` WHERE `student_ID` = '" . $_GET['student_ID'] . "'");

    echo '<script>alert("Student data deleted successfully.");window.location.replace("list.php");</script>';
}