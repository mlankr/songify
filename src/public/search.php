<?php
    include_once("includes/includedFiles.php");
    if (isset($_GET['term'])) {
        $term = urldecode($_GET['term']);
    } else {
        $term = "";
    }
?>

<div class="searchContainer">
    <h4>Search for an artist, album or song</h4>
    <label for="searchInput"></label>
    <input id="searchInput" type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing...">
</div>

<script src="assets/js/search.js"></script>

<?php
    if (empty(trim($term))) {
        exit();
    }
?>

<div class="trackListContainer borderBottom">
    <h2>SONGS</h2>
    <ul class="trackList">
        <?php
            $songsQuery = "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10";
            $songPrepareQuery = $pdo->prepare($songsQuery);
            $songPrepareQuery->execute();
            $songsData = $songPrepareQuery->fetchAll();

            if (empty($songsData)) {
                echo "<span class='noResults'>" . "No songs found matching " . $term . "</span>";
            }

            $songIdArray = array();

            foreach ($songsData as $i => $row) {
                if ($i > 15) {
                    break;
                }

                $songIdArray[] = $row['id'];
                $albumSong = new Song($pdo, $row['id']);
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

<div class="artistsContainer borderBottom">
    <h2>ARTISTS</h2>

    <?php
        $artistsQuery = "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10";
        $artistsPrepareQuery = $pdo->prepare($artistsQuery);
        $artistsPrepareQuery->execute();
        $artistsData = $artistsPrepareQuery->fetchAll();


        if (empty($artistsData)) {
            echo "<span class='noResults'>" . "No artists found matching " . $term . "</span>";
        }


        foreach ($artistsData as $row) {

            $artistFound = new Artist($pdo, $row['id']);

            echo "<div class='searchResultRow'>
                    <div class='artistName'>
                        <span role='link' tabindex='0' data-search-artist-id='" . $artistFound->getId() . "'>
                        " . $artistFound->getArtistName() . "
                        </span>
                    </div>
                  </div>";
        }
    ?>
</div>

<div class="gridViewContainer borderBottom">
    <h2>ALBUMS</h2>
    <?php
        $albumsQuery = "SELECT id FROM albums WHERE title LIKE '$term%' LIMIT 10";
        $prepareAlbumsQuery = $pdo->prepare($albumsQuery);
        $prepareAlbumsQuery->execute();
        $albumData = $prepareAlbumsQuery->fetchAll();

        if (empty($albumData)) {
            echo "<span class='noResults'>" . "No albums found matching " . $term . "</span>";
        }
        foreach ($albumData as $row) {
            $albumFound = new Album($pdo, $row['id']);


            echo "<div class='gridViewItem' data-search-album-id='" . $albumFound->getId() . "'>
                            <span role='link' tabindex='0' class='albumGrid'>
                                <img src='" . $albumFound->getArtworkPath() . "' alt='Album image'>
                                <div class='gridViewInfo'>" . $albumFound->getTitle() . "</div>
                            </span>
                    </div>";
        }
    ?>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistDropdown($pdo, $userLoggedIn->getUsername()); ?>
</nav>