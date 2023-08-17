<?php

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        include_once("includes/config.php");
        include_once("includes/utils/debug.php");
        include_once("includes/classes/User.php");
        include_once("includes/classes/Artist.php");
        include_once("includes/classes/Album.php");
        include_once("includes/classes/Song.php");
        include_once("includes/classes/Playlist.php");

        if (isset($_SESSION['userLoggedIn'])) {
            $userLoggedIn = new User($pdo, $_GET['userLoggedIn']);
        } else {
            echo "Currently not logged in! Please try again later";
            exit();
        }

    } else {
        include_once("includes/header.php");
        include_once("includes/footer.php");

        $url = $_SERVER['REQUEST_URI'];
        echo "<script>openPage('$url')</script>";
        exit();
    }
