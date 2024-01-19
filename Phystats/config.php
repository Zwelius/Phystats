<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
$connection = mysqli_connect("localhost", "root", "", "phystatsdb");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

function interpretation_score($interpretation)
{
    switch ($interpretation) {
        case "Poor":
            return 0;
            break;
        case "Needs Improvement":
            return 1;
            break;
        case "Fair":
            return 2;
            break;
        case "Good":
            return 3;
            break;
        case "Very Good":
            return 4;
            break;
        case "Excellent":
            return 5;
            break;
        case 0:
            return "Poor";
            break;
        case 1:
            return "Needs Improvement";
            break;
        case 2:
            return "Fair";
            break;
        case 3:
            return "Good";
            break;
        case 4:
            return "Very Good";
            break;
        case 5:
            return "Excellent";
            break;
        default:
            return 404;
            break;
    }
}
function zippertest_interpretation($zipper)
{
    if ($zipper < 0) {
        return "Poor";
    } else if ($zipper == 0) {
        return "Needs Improvement";
    } else if (0 < $zipper && $zipper < 2) {
        return "Fair";
    } else if (1.9 < $zipper && $zipper < 4) {
        return "Good";
    } else if (3.9 < $zipper && $zipper < 6) {
        return "Very Good";
    } else if ($zipper > 5.9) {
        return "Excellent";
    } else {
        return "Error";
    }
}
function sitAndReach_interpretation($sitreach)
{
    if ($sitreach < 0) {
        return "Poor";
    } else if (0 <= $sitreach && $sitreach < 16) {
        return "Needs Improvement";
    } else if (15.9 < $sitreach && $sitreach < 31) {
        return "Fair";
    } else if (30.9 < $sitreach && $sitreach < 46) {
        return "Good";
    } else if (45.9 < $sitreach && $sitreach < 61) {
        return "Very Good";
    } else if ($sitreach > 60.9) {
        return "Excellent";
    } else {
        return "Error";
    }
}
function flexibility($zipperRight, $zipperLeft, $sitReach1, $sitReach2)
{
    $zipper = ($zipperRight + $zipperLeft) / 2;
    if ($sitReach1 >= $sitReach2) {
        $sitReachBest = $sitReach1;
    } else {
        $sitReachBest = $sitReach2;
    }
    $zipperInterpretation = zippertest_interpretation($zipper);
    $sitReachInterpretation = sitAndReach_interpretation($sitReachBest);
    $zipScore = interpretation_score($zipperInterpretation);
    $sitScore = interpretation_score($sitReachInterpretation);
    $temp = ($zipScore + $sitScore) / 2;
    $flexibility = round($temp);
    return interpretation_score($flexibility);
}
