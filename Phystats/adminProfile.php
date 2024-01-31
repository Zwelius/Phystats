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
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phystats - Admin Profile</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.ico">
    <link rel="stylesheet" href="css/nav.css" />
    <link rel="stylesheet" href="css/profile.css" />
</head>

<body>
    <?php
    include 'config.php';
    if (empty($_SESSION["principal_ID"])) {
        header("Location: index.php");
    } else {
        $principal_ID = $_SESSION["principal_ID"];

        $viewsql = mysqli_query($connection, "SELECT * FROM `principal_tb`WHERE principal_ID = $principal_ID");
        while ($row = mysqli_fetch_assoc($viewsql)) {
            $principal_NAME = $row['principal_NAME'];
            $principal_EMAIL = $row['principal_EMAIL'];
            $principal_PASSWORD = $row['principal_PASSWORD'];
        }

        if (isset($_POST['update'])) {
            if (isset($_POST['update'])) {
                $updateprofsql = mysqli_query($connection, "UPDATE `principal_tb` SET `principal_NAME`='" . $_POST['name'] . "', `principal_EMAIL`='" . $_POST['email'] . "', `principal_PASSWORD`='" . $_POST['pass'] . "' WHERE `principal_ID`='$principal_ID'");
                if (mysqli_errno($connection) == 1062) {
                    echo '<script>alert("Principal account or email already exists. Please your IT support if there are problems.");</script>';
                } elseif (mysqli_errno($connection)) {
                    echo '<script>alert("An error occurred while updating your profile. Please try again later.");</script>';
                } else {
                    echo '<script>alert("Updated successfully");window.location.replace("adminProfile.php");</script>';
                }
            }
        } else if (isset($_POST['logout'])) {
            unset($_SESSION["principal_ID"]);
            echo '<script>window.location.replace("index.php");</script>';
            exit();
        } else if (isset($_POST['reset'])) {
            $updateprofsql = mysqli_query($connection, "UPDATE `principal_tb` SET `principal_NAME`='Seaside Elementary School', `principal_EMAIL`='seasideadmin@gmail.com', `principal_PASSWORD`='seaside123' WHERE `principal_ID`='$principal_ID'");

            unset($_SESSION["principal_ID"]);
            echo '<script>window.location.replace("index.php");</script>';
            exit();
        }
    }
    ?>
    <nav>
        <div>
            <img class="logo" src="assets/wlogo.png">
            <h1 class="title">Phystats</h1>
        </div>
        <div>
            <a href="dashboard.php" class="nav-options">DASHBOARD</a>
            <a href="#" class="nav-options">MANAGE</a>
            <a href="adminProfile.php" class="here nav-options"><img class="profile" src="assets/wprof.png"></a>
        </div>
    </nav>

    <main>
        <form method="POST">
            <section>
                <div class="left">
                    <p><span class="account-settings">Account Settings</span><br>
                        <span class="page-description">Manage your profile</span>
                    </p>
                    <div class="personal-details">
                        <a href="adminProfile.php">
                            <div class="selected-option">Personal Details</div>
                        </a>
                    </div>

                    <div class="selection-container">
                        <input type="submit" name="reset" value="Reset Principal Account" formnovalidate onclick="return confirm('Are you sure you want to reset account?')">
                    </div>

                    <div class="selection-container">
                        <input type="submit" name="logout" value="Logout" formnovalidate onclick="return confirm('Are you sure you want to logout?')">
                    </div>
                </div>

                <div class="right">
                    <span>Personal Details</span>
                    <hr>
                    <main>
                        <div class="personal-details-left">
                            <label>PRINCIPAL NAME</label><br>
                            <input type="text" name="name" value="<?php echo $principal_NAME ?>" required><br>
                            <label>CHANGE EMAIL & PASSWORD</label><br>
                            <input type="text" name="email" placeholder="Email" value="<?php echo $principal_EMAIL ?>" required>
                            <input type="password" name="pass" placeholder="Password" value="<?php echo $principal_PASSWORD ?>" required><br><br><br>
                            <input type="submit" name="update" value="Save Changes" onclick="return confirm('You are about to do some changes. Do you want to proceed?')">
                        </div>
                    </main>
                </div>
            </section>
        </form>
    </main>
</body>

</html>