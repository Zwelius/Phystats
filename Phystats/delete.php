<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require 'config.php';
if (isset($_GET['testdata_ID'])) {
    mysqli_query($connection, "DELETE FROM `studenttestdata_tb` WHERE `testdata_ID` = '" . $_GET['testdata_ID'] . "'");

    echo '<script>alert("Student data deleted successfully.");window.location.replace("list.php");</script>';
}