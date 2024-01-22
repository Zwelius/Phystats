<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
$connection = mysqli_connect("localhost", "root", "", "phystatsdb");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}


function getAge($Birthdate){
    $nowdate = date("Y-m-d");
    $getage = date_diff(date_create($Birthdate), date_create($nowdate));
    $age = $getage->format('%y');
    return $age;
}
function minuteStep_interpretation($HRate, $age)
{
    if ($age >= 6 && $age <= 11) {
        if (40 <= $HRate && $HRate < 80) {
            return "Excellent";
        } else if (80 <= $HRate && $HRate <= 94) {
            return "Very Good";
        } else if (95 <= $HRate && $HRate <= 104) {
            return "Good";
        } else if (105 <= $HRate && $HRate <= 115) {
            return "Fair";
        } else if (116 <= $HRate && $HRate <= 130) {
            return "Needs Improvement";
        } else {
            return "Poor";
        }
    } else if ($age >= 12 && $age <= 17) {
        if (40 <= $HRate && $HRate < 75) {
            return "Excellent";
        } else if (75 <= $HRate && $HRate <= 89) {
            return "Very Good";
        } else if (90 <= $HRate && $HRate <= 99) {
            return "Good";
        } else if (100 <= $HRate && $HRate <= 109) {
            return "Fair";
        } else if (110 <= $HRate && $HRate <= 125) {
            return "Needs Improvement";
        } else {
            return "Poor";
        }
    } else {
        return "Error";
    }
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
function plank_interpretation($plankTime)
{
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
function hexagonAgility_interpretation($hexagon)
{
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
function standingLongJump_interpretation($SLJ)
{
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
function storkBalance_interpretation($score, $age)
{
    if ($age >= 6 && $age <= 12) {
        if ($score >= 41) {
            return "Excellent";
        } elseif ($score >= 31 && $score <= 40) {
            return "Very Good";
        } elseif ($score >= 21 && $score <= 30) {
            return "Good";
        } elseif ($score >= 11 && $score <= 20) {
            return "Fair";
        } elseif ($score >= 1 && $score <= 10) {
            return "Needs Improvement";
        }
    } elseif ($age >= 13 && $age <= 14) {
        if ($score >= 81) {
            return "Excellent";
        } elseif ($score >= 61 && $score <= 80) {
            return "Very Good";
        } elseif ($score >= 41 && $score <= 60) {
            return "Good";
        } elseif ($score >= 21 && $score <= 40) {
            return "Fair";
        } elseif ($score >= 1 && $score <= 20) {
            return "Needs Improvement";
        }
    } elseif ($age >= 15 && $age <= 16) {
        if ($score >= 121) {
            return "Excellent";
        } elseif ($score >= 91 && $score <= 120) {
            return "Very Good";
        } elseif ($score >= 61 && $score <= 90) {
            return "Good";
        } elseif ($score >= 31 && $score <= 60) {
            return "Fair";
        } elseif ($score >= 1 && $score <= 30) {
            return "Needs Improvement";
        }
    } elseif ($age >= 17) {
        if ($score >= 161) {
            return "Excellent";
        } elseif ($score >= 121 && $score <= 160) {
            return "Very Good";
        } elseif ($score >= 81 && $score <= 120) {
            return "Good";
        } elseif ($score >= 41 && $score <= 80) {
            return "Fair";
        } elseif ($score >= 1 && $score <= 40) {
            return "Needs Improvement";
        }
    } else {
        return "Error";
    }
}
function stickDrop_interpretation($stickDrop)
{
    if ($stickDrop > 30.48) {
        return "Poor";
    } else if (26.66 < $stickDrop && $stickDrop < 30.49) {
        return "Needs Improvement";
    } else if (19.04 < $stickDrop && $stickDrop < 26.67) {
        return "Fair";
    } else if (11.42 < $stickDrop && $stickDrop < 19.05) {
        return "Good";
    } else if (3.74 < $stickDrop && $stickDrop < 11.43) {
        return "Very Good";
    } else if ($stickDrop < 3.75) {
        return "Excellent";
    } else {
        return "Error";
    }
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
            return "Error";
    }
}
function bodyComposition($bodyComposition)
{
    switch ($bodyComposition) {
        case "Severely Wasted":
            return 1;
        case "Obese":
            return 1;
        case "Wasted":
            return 3;
        case "Overweight":
            return 3;
        case "Normal":
            return 5;
        default:
            return "Error";
    }
}
function cardiovasulcarEndurance($HRbefore, $HRafter, $age)
{
    $HRateB = minuteStep_interpretation($HRbefore, $age);
    $HRateA = minuteStep_interpretation($HRafter, $age);
    $HRBeforeInterpretation = interpretation_score($HRateB);
    $HRAfterInterpretation = interpretation_score($HRateA);
    $temp = ($HRBeforeInterpretation + $HRAfterInterpretation) / 2;
    $cardiovascularEndurance = round($temp);
    return interpretation_score($cardiovascularEndurance);
}
function strength($pushupsNo, $plankTime)
{
    $pushupsInterpretation = pushups_interpretation($pushupsNo);
    $plankInterpretation = plank_interpretation($plankTime);
    $pushupScore = interpretation_score($pushupsInterpretation);
    $plankScore = interpretation_score($plankInterpretation);
    $temp = ($pushupScore + $plankScore) / 2;
    $strength = round($temp);
    return interpretation_score($strength);
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
function coordination($juggling)
{
    if ($juggling <= 0) {
        return "Poor";
    } else if (0 < $juggling && $juggling < 11) {
        return "Needs Improvement";
    } else if (10 < $juggling && $juggling < 21) {
        return "Fair";
    } else if (20 < $juggling && $juggling < 31) {
        return "Good";
    } else if (30 < $juggling && $juggling < 41) {
        return "Very Good";
    } else if ($juggling > 40) {
        return "Excellent";
    } else {
        return "Error";
    }
}
function agility($hexagon1, $hexagon2)
{
    $hexagon = ($hexagon1 + $hexagon2) / 2;
    $hexagonAgility = round($hexagon);
    $hexagonInterpretation = hexagonAgility_interpretation($hexagonAgility);
    return $hexagonInterpretation;
}
function speed($sprintTime, $age, $sex)
{
    if ($sex == 'Male') {
        if ($age >= 6 && $age <= 12) {
            if ($sprintTime < 6.0) {
                return 'Excellent';
            } elseif ($sprintTime >= 6.1 && $sprintTime <= 7.7) {
                return 'Very Good';
            } elseif ($sprintTime >= 7.8 && $sprintTime <= 8.5) {
                return 'Good';
            } elseif ($sprintTime >= 8.6 && $sprintTime <= 9.5) {
                return 'Fair';
            } else {
                return 'Needs Improvement';
            }
        } elseif ($age >= 13 && $age <= 14) {
            if ($sprintTime < 5.0) {
                return 'Excellent';
            } elseif ($sprintTime >= 5.1 && $sprintTime <= 6.9) {
                return 'Very Good';
            } elseif ($sprintTime >= 7.0 && $sprintTime <= 8.0) {
                return 'Good';
            } elseif ($sprintTime >= 8.1 && $sprintTime <= 9.1) {
                return 'Fair';
            } else {
                return 'Needs Improvement';
            }
        } elseif ($age >= 15 && $age <= 16) {
            if ($sprintTime < 4.5) {
                return 'Excellent';
            } elseif ($sprintTime >= 4.6 && $sprintTime <= 5.4) {
                return 'Very Good';
            } elseif ($sprintTime >= 5.5 && $sprintTime <= 7.0) {
                return 'Good';
            } elseif ($sprintTime >= 7.1 && $sprintTime <= 8.1) {
                return 'Fair';
            } else {
                return 'Needs Improvement';
            }
        } elseif ($age >= 17) {
            if ($sprintTime < 4.0) {
                return 'Excellent';
            } elseif ($sprintTime >= 4.1 && $sprintTime <= 5.4) {
                return 'Very Good';
            } elseif ($sprintTime >= 5.5 && $sprintTime <= 6.5) {
                return 'Good';
            } elseif ($sprintTime >= 6.6 && $sprintTime <= 7.5) {
                return 'Fair';
            } else {
                return 'Needs Improvement';
            }
        } else {
            return "Error";
        }
    } elseif ($sex == 'Female') {
        if ($age >= 6 && $age <= 12) {
            if ($sprintTime < 7.0) {
                return 'Excellent';
            } elseif ($sprintTime >= 7.1 && $sprintTime <= 8.4) {
                return 'Very Good';
            } elseif ($sprintTime >= 8.5 && $sprintTime <= 9.5) {
                return 'Good';
            } elseif ($sprintTime >= 9.6 && $sprintTime <= 10.5) {
                return 'Fair';
            } else {
                return 'Needs Improvement';
            }
        } elseif ($age >= 13 && $age <= 14) {
            if ($sprintTime < 6.5) {
                return 'Excellent';
            } elseif ($sprintTime >= 6.6 && $sprintTime <= 7.6) {
                return 'Very Good';
            } elseif ($sprintTime >= 7.7 && $sprintTime <= 8.8) {
                return 'Good';
            } elseif ($sprintTime >= 8.9 && $sprintTime <= 9.5) {
                return 'Fair';
            } else {
                return 'Needs Improvement';
            }
        } elseif ($age >= 15 && $age <= 16) {
            if ($sprintTime < 5.5) {
                return 'Excellent';
            } elseif ($sprintTime >= 5.6 && $sprintTime <= 6.1) {
                return 'Very Good';
            } elseif ($sprintTime >= 6.2 && $sprintTime <= 7.2) {
                return 'Good';
            } elseif ($sprintTime >= 7.3 && $sprintTime <= 8.5) {
                return 'Fair';
            } else {
                return 'Needs Improvement';
            }
        } elseif ($age >= 17) {
            if ($sprintTime < 4.5) {
                return 'Excellent';
            } elseif ($sprintTime >= 4.6 && $sprintTime <= 5.9) {
                return 'Very Good';
            } elseif ($sprintTime >= 6.0 && $sprintTime <= 7.0) {
                return 'Good';
            } elseif ($sprintTime >= 7.1 && $sprintTime <= 8.1) {
                return 'Fair';
            } else {
                return 'Needs Improvement';
            }
        } else {
            return "Error";
        }
    }
}

function power($SLJ1, $SLJ2)
{
    $SLJ1Interpretation = standingLongJump_interpretation($SLJ1);
    $SLJ2Interpretation = standingLongJump_interpretation($SLJ2);
    $SLJ1score = interpretation_score($SLJ1Interpretation);
    $SLJ2score = interpretation_score($SLJ2Interpretation);
    $temp = ($SLJ1score + $SLJ2score) / 2;
    $power = round($temp);
    return interpretation_score($power);
}
function balance($storkRight, $storkLeft, $age)
{
    $storkRightInterpretation = storkBalance_interpretation($storkRight, $age);
    $storkLeftInterpretation = storkBalance_interpretation($storkLeft, $age);
    $storkRightscore = interpretation_score($storkRightInterpretation);
    $storkLeftscore = interpretation_score($storkLeftInterpretation);
    $temp = ($storkRightscore + $storkLeftscore) / 2;
    $balance = round($temp);
    return interpretation_score($balance);
}
function reactionTime($stick1, $stick2, $stick3)
{
    if (($stick2 >= $stick1 && $stick1 >= $stick3) || ($stick3 >= $stick1 && $stick1 >= $stick2)) {
        $stickMiddle = $stick1;
    } else if (($stick1 >= $stick2 && $stick2 >= $stick3) || ($stick3 >= $stick2 && $stick2 >= $stick1)) {
        $stickMiddle = $stick2;
    } else if (($stick2 >= $stick3 && $stick3 >= $stick1) || ($stick1 >= $stick3 && $stick3 >= $stick2)) {
        $stickMiddle = $stick3;
    }
    $stickDropInterpretation = stickDrop_interpretation($stickMiddle);
    return $stickDropInterpretation;
}
function physicallyFit($bodyComposition, $cardiovascularEndurance, $strength, $flexibility, $coordination, $agility, $speed, $power, $balance, $reactionTime)
{
    $fitness = (bodyComposition($bodyComposition) + interpretation_score($cardiovascularEndurance) + interpretation_score($strength) + interpretation_score($flexibility) + interpretation_score($coordination) + interpretation_score($agility) + interpretation_score($speed) + interpretation_score($power) + interpretation_score($balance) + interpretation_score($reactionTime)) / 10;
    $result = number_format((float)$fitness, 2, '.', '');
    if ($result >= 3) {
        return "Physically Fit";
    } else {
        return "Not Physically Fit";
    }
}