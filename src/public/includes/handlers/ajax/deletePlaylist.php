<?php

include_once("../../config.php");

if (isset($_POST['playlistId'])) {
    $playlistToBeDeleted = strip_tags($_POST['playlistId']);

    if ($playlistToBeDeleted && (int)$playlistToBeDeleted < 0) {
        echo json_encode(array('error' => 'Playlist cannot be deleted'));
        return;
    }

    $playlistQuery = "DELETE FROM playlists WHERE id=?";
    $playlistSongsQuery = "DELETE FROM playlistSongs WHERE playlistId=?";

    $playlistPrepareQuery = $pdo->prepare($playlistQuery);
    $playlistSongsPrepareQuery = $pdo->prepare($playlistSongsQuery);

    if ($playlistPrepareQuery->execute([$playlistToBeDeleted]) && $playlistSongsPrepareQuery->execute([$playlistToBeDeleted])) {
        echo json_encode(array('success' => 'Playlist deleted'));
        return;
    }
} else {
    echo json_encode(array('error' => 'Something went wrong!!! Please try again later'));
    return;
}
