<?php
session_start();
require_once(__DIR__."/../dictionary.php");
$lan = $_GET['lan'] ?? 'en';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css" />
    <script src="js/app.js" defer></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <title><?= $_title ?? 'COMPANY' ?></title>
</head>
<body class="<?= $_className ?? 'body' ?> 
<?php
    echo "standard";
?>"> 

<!-- <div><a href="index">Home</a></div>
<div><a href="login">Log in</a></div>
<div><a href="signup">Sign up</a></div>-->
<header>
        <nav class="main-nav">
            <a href="index.php"><img class="logo" src="images/logo.svg" /></a>

            <div class="log-in-content">
                <span class="triangle"></span>
                <?php
                if (!isset($_SESSION['user_name'])) {
                    echo '<a href="login.php"><button class="sign-in">Log in</button></a>';
                }
                ?>
                <p class="new-user">New customer? <a href="signup.php">Start here</a></p>
            </div>

        </nav>
        <nav class="sub-nav">
        <p class="signed-name">
                <?php
                if (isset($_SESSION['user_name'])) {
                    echo ' <a class="settings" href="profile.php">'.$text['3'][$lan].'</a>';
                }
                ?>
            </p>
            <p class="signed-name">
                <?php
                if (isset($_SESSION['user_name'])) {
                    echo $text['4'][$lan];
                    echo $_SESSION['user_name'];
                    echo ' <a class="settings" href="bridges/logout.php">'.$text['5'][$lan].'</a>';
                }
                ?>
            </p>
            <p class="signed-name">
                <?php
                if (!isset($_SESSION['user_name'])) {
                    echo $text['1'][$lan];
                    echo '<a class="nav-sign-in" href="login.php">'.$text['2'][$lan].'</a>';
                }
                ?>
            </p>
        </nav>
    </header>

    <div class="breadcrumbs"></div>