<?php

    include_once("../../config.php");

    if (isset($_POST['playlistName']) && isset($_POST['username'])) {
        $playlistName = strip_tags($_POST['playlistName']);
        $username = $_POST['username'];
        $date = date("Y-m-d");

        if (empty($playlistName)) {
            echo json_encode(array('error' => 'Playlist name is empty'));
            return;
        }

        $playlistQuery = "INSERT INTO playlists(name, owner, dateCreated) VALUES(?,?,?)";
        $playlistPrepareQuery = $pdo->prepare($playlistQuery);
        if ($playlistPrepareQuery->execute(array($playlistName, $username, $date))) {
            echo json_encode(array('success' => 'Playlist created'));
            return;
        }
    } else {
        echo json_encode(array('error' => 'Something went wrong!!! Please try again later'));
        return;
    }
