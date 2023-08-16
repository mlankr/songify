<?php
    include_once("includes/config.php");
    include_once("includes/utils/debug.php");
    include_once("includes/classes/User.php");
    include_once("includes/classes/Artist.php");
    include_once("includes/classes/Album.php");
    include_once("includes/classes/Song.php");
    include_once("includes/classes/Playlist.php");

    if (isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = new User($pdo, $_SESSION['userLoggedIn']);
        $username =$userLoggedIn->getUsername();
        echo "<script>window.userLoggedIn = '$username';</script>";
    } else {
        header("Location: register.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to Songify!</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="assets/js/libs/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="mainContainer">
        <div id="topContainer">
            <?php include("includes/navBarContainer.php"); ?>

            <div id="mainViewContainer">
                <div id="mainContent">