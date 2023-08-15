<?php

    include_once("../../config.php");
    include_once("../../classes/Album.php");

    if (isset($_POST['albumId'])) {
        $albumId = $_POST['albumId'];
        $album = new Album($pdo, $albumId);
        echo json_encode($album->getAlbumData());
    }