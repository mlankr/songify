<?php
    include_once("includes/includedFiles.php");

    if (isset($_GET['id'])) {
        $albumId = $_GET['id'];

        $album = new Album($pdo, $albumId);
        $artist = $album->getArtist();

    } else {
        header("Location: index.php");
        exit();
    }

?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>" alt="">
    </div>
    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p>By <?php echo $artist->getArtistName(); ?></p>
        <p><?php echo $album->getNumberOfSongs(); ?> songs</p>
    </div>
</div>
<div class="trackListContainer">
    <ul class="trackList">
        <?php
            $songIdArray = $album->getSongIds();

            foreach ($songIdArray as $i => $songId) {

                $albumSong = new Song($pdo, $songId);
                $albumArtist = $albumSong->getArtist();

                echo "<li class='trackListRow'>
                           <div class='trackCount'>
                            <img src='assets/images/icons/play-white.png' alt='Play' class='play' data-song-id='" . $albumSong->getId() . "'>
                                <span class='trackNumber'>" . ($i + 1) . "</span>
                           </div>
                            
                           <div class='trackInfo'>
                                <span class='trackName'>" . $albumSong->getTitle() . "</span>                     
                                <span class='artistName'>" . $albumArtist->getArtistName() . "</span>                     
                           </div>
                            
                           <div class='trackOptions'>
                                <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                <img src='assets/images/icons/more.png' alt='Options' class='optionsButton'>                     
                           </div>
                            
                           <div class='trackDuration'>
                                <span class='duration'>" . $albumSong->getDuration() . "</span>                     
                           </div>
                        </li>";
            }
        ?>

        <script>
            window.tempSongsIds = '<?php echo json_encode($songIdArray); ?>';
            window.tempPlaylist = JSON.parse(tempSongsIds);
        </script>

    </ul>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistDropdown($pdo, $userLoggedIn->getUsername()); ?>
</nav>


















