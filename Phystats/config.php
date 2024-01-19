<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
$connection = mysqli_connect("localhost", "root", "", "phystatsdb");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

function zippertest_interpretation($zipper, $interpretation){
    if ($zipper < 0) {
        $interpretation = "Poor";
    }else if ($zipper = 0){
        $interpretation = "Needs Improvement";
    }else if (0 < $zipper && $zipper < 2){
        $interpretation = "Fair";
    }else if (1.9 < $zipper && $zipper < 4){
        $interpretation = "Good";
    }else if (3.9 < $zipper && $zipper < 6){
        $interpretation = "Very Good";
    }else if (5.9 < $zipper){
        $interpretation = "Excellent";
    }
    return $interpretation;
}
function flexibility(){

}