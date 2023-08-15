<?php
    include("includes/includedFiles.php");

    if (isset($_GET['id'])) {
        $artistId = $_GET['id'];

        $artist = new Artist($pdo, $artistId);
    } else {
        header("Location: index.php");
        exit();
    }
?>

<div class="entityInfo borderBottom">
    <div class="centerSection">

        <div class="artistInfo">
            <h1 class="artistName"><?php echo $artist->getArtistName(); ?></h1>

            <div class="headerButtons">
                <button class="button playButtonInArtist button-green">PLAY</button>
            </div>
        </div>

    </div>
</div>

<div class="trackListContainer borderBottom">
    <h2>SONGS</h2>
    <ul class="trackList">
        <?php
            $songIdArray = $artist->getSongIds();

            foreach ($songIdArray as $i => $songId) {
                if ($i > 5) {
                    break;
                }

                $albumSong = new Song($pdo, $songId);
                $albumArtist = $albumSong->getArtist();

                echo "<li class='trackListRow'>
                           <div class='trackCount'>
                            <img src='assets/images/icons/play-white.png' alt='Play' class='play' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
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

<div class="gridViewContainer">
    <h2>ALBUMS</h2>
    <?php
        $albumQuery = "SELECT * FROM albums WHERE artist='$artistId'";
        $prepareQuery = $pdo->prepare($albumQuery);
        $prepareQuery->execute();

        $allRows = $prepareQuery->fetchAll();
        foreach ($allRows as $row) {
            echo "<div class='gridViewItem'>
                        <span role='link' tabindex='0' class='albumGrid'  onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
                            <img src='" . $row['artworkPath'] . "'>
                            <div class='gridViewInfo'>" . $row['title'] .
                "</div>
                        </span>
                </div>";
        }
    ?>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistDropdown($pdo, $userLoggedIn->getUsername()); ?>
</nav>