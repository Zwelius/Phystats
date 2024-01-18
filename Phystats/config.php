<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
$connection = mysqli_connect("localhost", "root", "", "phystatsdb");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

function nutristatus($bmi,$sex,$age){
    if ($sex == "Male") {
        
    }else if ($sex == "Female"){
        
    }
}