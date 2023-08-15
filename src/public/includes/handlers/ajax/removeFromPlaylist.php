<?php

    include_once("../../config.php");

    if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
        $playlistId = strip_tags(trim($_POST['playlistId']));
        $songId = strip_tags(trim($_POST['songId']));

        if (empty($playlistId) || empty($songId)) {
            echo json_encode(array('error' => 'Missing Information!'));
            return;
        }

            $playlistSongQuery = "DELETE FROM playlistSongs WHERE playlistId='$playlistId' AND songId='$songId'";
            $playlistSongPrepareQuery = $pdo->prepare($playlistSongQuery);

            if ($playlistSongPrepareQuery->execute()) {
                echo json_encode(array('success' => 'Song successfully removed from playlist'));
                return;
        }
    } else {
        echo json_encode(array('error' => 'Something went wrong!!! Please try again later'));
        return;
    }