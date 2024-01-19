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
        case "Needs Improvement":
            return 1;
        case "Fair":
            return 2;
        case "Good":
            return 3;
        case "Very Good":
            return 4;
        case "Excellent":
            return 5;
        case 0:
            return "Poor";
        case 1:
            return "Needs Improvement";
        case 2:
            return "Fair";
        case 3:
            return "Good";
        case 4:
            return "Very Good";
        case 5:
            return "Excellent";
        default:
            return 404;
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
function pushups_interpretation($pushupsNo)
{
    if ($pushupsNo <= 0) {
        return "Poor";
    } else if (0 < $pushupsNo && $pushupsNo < 6) {
        return "Needs Improvement";
    } else if (5 < $pushupsNo && $pushupsNo < 11) {
        return "Fair";
    } else if (10 < $pushupsNo && $pushupsNo < 16) {
        return "Good";
    } else if (15 < $pushupsNo && $pushupsNo < 21) {
        return "Very Good";
    } else if ($pushupsNo > 20) {
        return "Excellent";
    } else {
        return "Error";
    }
}
function plank_interpretation($plankTime){
    if ($plankTime <= 0) {
        return "Poor";
    } else if (0 < $plankTime && $plankTime < 16) {
        return "Needs Improvement";
    } else if (15 < $plankTime && $plankTime < 31) {
        return "Fair";
    } else if (30 < $plankTime && $plankTime < 46) {
        return "Good";
    } else if (45 < $plankTime && $plankTime < 51) {
        return "Very Good";
    } else if ($plankTime > 50) {
        return "Excellent";
    } else {
        return "Error";
    }
}
function strength($pushupsNo, $plankTime){
    $pushupsInterpretation = zippertest_interpretation($pushupsNo);
    $plankInterpretation = sitAndReach_interpretation($plankTime);
    $pushupScore = interpretation_score($pushupsInterpretation);
    $plankScore = interpretation_score($plankInterpretation);
    $temp = ($pushupScore + $plankScore) / 2;
    $strength = round($temp);
    return interpretation_score($strength);
}
function standingLongJump_interpretation($SLJ){
    if ($SLJ < 55) {
        return "Poor";
    } else if (54 < $SLJ && $SLJ < 101) {
        return "Needs Improvement";
    } else if (100 < $SLJ && $SLJ < 126) {
        return "Fair";
    } else if (125 < $SLJ && $SLJ < 151) {
        return "Good";
    } else if (150 < $SLJ && $SLJ < 201) {
        return "Very Good";
    } else if ($SLJ > 200) {
        return "Excellent";
    } else {
        return "Error";
    }
}
function power($SLJ1, $SLJ2){
    $SLJ1Interpretation = standingLongJump_interpretation($SLJ1);
    $SLJ2Interpretation = standingLongJump_interpretation($SLJ2);
    $SLJ1score = interpretation_score($SLJ1Interpretation);
    $SLJ2score = interpretation_score($SLJ2Interpretation);
    $temp = ($SLJ1score + $SLJ2score) / 2;
    $power = round($temp);
    return interpretation_score($power);
}
function hexagonAgility_interpretation($hexagon){
    if ($hexagon > 25) {
        return "Poor";
    } else if (20 < $hexagon && $hexagon < 26) {
        return "Needs Improvement";
    } else if (15 < $hexagon && $hexagon < 21) {
        return "Fair";
    } else if (10 < $hexagon && $hexagon < 16) {
        return "Good";
    } else if (5 < $hexagon && $hexagon < 11) {
        return "Very Good";
    } else if ($hexagon < 6) {
        return "Excellent";
    } else {
        return "Error";
    }
}
function agility($hexagon1, $hexagon2){
    
}