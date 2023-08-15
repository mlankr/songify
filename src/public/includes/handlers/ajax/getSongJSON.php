<?php

    include_once("../../config.php");
    include_once("../../classes/Song.php");

    if (isset($_POST['songId'])) {
        $songId = $_POST['songId'];
        $song = new Song($pdo, $songId);
        echo json_encode($song->getSongData());
    }