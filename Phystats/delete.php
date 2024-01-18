<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require 'config.php';
if (isset($_GET['s_id'])) {
    mysqli_query($connection, "DELETE FROM `student` WHERE `s_id` = '" . $_GET['s_id'] . "'");

    echo '<script>alert("Student data deleted successfully.");window.location.replace("list.php");</script>';
}