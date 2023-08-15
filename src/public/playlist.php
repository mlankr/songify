<?php
    include_once("includes/includedFiles.php");
    include_once("includes/modal.php");

    if (isset($_GET['id'])) {
        $playlistId = $_GET['id'];

        $playlist = new Playlist($pdo, $playlistId);
        $owner = new User($pdo, $playlist->getOwner());
    } else {
        header("Location: index.php");
        exit();
    }

?>

<div class="entityInfo">
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/icons/playlistGreen.png" alt="Playlist icon">
        </div>
    </div>
    <div class="rightSection">
        <h2><?php echo $playlist->getName(); ?></h2>
        <p>By <?php echo $playlist->getOwner(); ?></p>
        <p><?php echo $playlist->getNumberOfSongs() <= 1 ? $playlist->getNumberOfSongs() . ' song' : $playlist->getNumberOfSongs() . ' songs' ?></p>
        <button class="button deletePlaylist button-red" data-playlistId="<?php echo $playlistId; ?>">DELETE
            PLAYLIST
        </button>
    </div>
</div>
<div class="trackListContainer">
    <ul class="trackList">
        <?php
            $songIdArray = $playlist->getSongIds();

            foreach ($songIdArray as $i => $songId) {
                $playlistSong = new Song($pdo, $songId);
                $songArtist = $playlistSong->getArtist();

                echo "<li class='trackListRow'>
                           <div class='trackCount'>
                            <img src='assets/images/icons/play-white.png' alt='Play' class='play' data-song-id='" . $playlistSong->getId() . "'>
                                <span class='trackNumber'>" . ($i + 1) . "</span>
                           </div>
                            
                           <div class='trackInfo'>
                                <span class='trackName'>" . $playlistSong->getTitle() . "</span>                     
                                <span class='artistName'>" . $songArtist->getArtistName() . "</span>                     
                           </div>
                            
                           <div class='trackOptions'>
                                <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
                                <img src='assets/images/icons/more.png' alt='Options' class='optionsButton'>                     
                           </div>
                            
                           <div class='trackDuration'>
                                <span class='duration'>" . $playlistSong->getDuration() . "</span>                     
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
    <div class="item removeFromPlaylist" data-removePlaylistId="<?php echo $playlistId; ?>">Remove From Playlist</div>
</nav>