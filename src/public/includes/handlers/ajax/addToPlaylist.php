<?php

    include_once("../../config.php");

    if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
        $playlistId = strip_tags(trim($_POST['playlistId']));
        $songId = strip_tags(trim($_POST['songId']));

        if (empty($playlistId) || empty($songId)) {
            echo json_encode(array('error' => 'Missing Information!'));
            return;
        }

        $songAlreadyInPlaylistQuery = "SELECT id FROM playlistSongs WHERE playlistId='$playlistId' AND songId='$songId'";
        $songAlreadyInPlaylistPrepareQuery = $pdo->prepare($songAlreadyInPlaylistQuery);
        $songAlreadyInPlaylistPrepareQuery->execute();
        $isSongPresent = $songAlreadyInPlaylistPrepareQuery->rowCount() > 0;

        if (!$isSongPresent) {
            $orderIdPlaylistSongQuery = "SELECT IFNULL(MAX(playlistOrder) + 1, 1) as playlistOrder FROM playlistSongs WHERE playlistId='$playlistId'";
            $orderIdPlaylistSongPrepareQuery = $pdo->prepare($orderIdPlaylistSongQuery);
            $orderIdPlaylistSongPrepareQuery->execute();
            $playlistOrder = $orderIdPlaylistSongPrepareQuery->fetch(PDO::FETCH_ASSOC);
            $order = $playlistOrder['playlistOrder'];

            if ($order) {
                $playlistSongQuery = "INSERT INTO playlistSongs(songId, playlistId, playlistOrder) VALUES(?,?,?)";
                $playlistSongPrepareQuery = $pdo->prepare($playlistSongQuery);

                if ($playlistSongPrepareQuery->execute(array($songId, $playlistId, $order))) {
                    echo json_encode(array('success' => 'Song successfully added to playlist'));
                    return;
                }
            }
        }
    } else {
        echo json_encode(array('error' => 'Something went wrong!!! Please try again later'));
        return;
    }