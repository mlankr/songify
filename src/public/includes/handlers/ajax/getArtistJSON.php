<?php
    include_once("../../config.php");
    include_once("../../classes/Artist.php");

    if (isset($_POST['artistId'])) {
        $artistId = $_POST['artistId'];
        $artist = new Artist($pdo, $artistId);
        echo json_encode($artist->getArtistData());
    }