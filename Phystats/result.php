<?php
session_start();
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>

<head>
    <meta charset="UTF-8">
    <title>Phystats - Test Results</title>
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/result.css" />
</head>

<body>
    <?php
    include 'config.php';
    if (empty($_SESSION["t_id"])) {
        header("Location: index.php");
    } else {

    }
    ?>
    <nav>
        <div>
            <img class="logo" src="assets/wlogo.png">
            <h1 class="title">Phystats</h1>
        </div>
        <div>
            <a href="list.php" class="nav-options">STUDENT LIST</a>
            <a href="result.php" class="here nav-options">TEST RESULTS</a>
            <a href="profile.php" class="nav-options"><img class="profile" src="assets/wprof.png"></a>
        </div>
    </nav>
</body>

</html>