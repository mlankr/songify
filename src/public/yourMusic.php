<?php
    include_once("includes/includedFiles.php");
    include_once("includes/modal.php")
?>

<div class="playListContainer">

    <div class="gridViewContainer">
        <h2>PLAYLISTS</h2>
        <div class="buttonItems">
            <button class="button playlistButton button-green">NEW PLAYLIST</button>
        </div>

        <?php
            $username = $userLoggedIn->getUsername();
            $playlistsQuery = "SELECT * FROM playlists WHERE owner='$username'";
            $preparePlaylistsQuery = $pdo->prepare($playlistsQuery);
            $preparePlaylistsQuery->execute();
            $playlistData = $preparePlaylistsQuery->fetchAll();

            if (empty($playlistData)) {
                echo "<span class='noResults'>You don't have any playlist yet</span>";
            }
            foreach ($playlistData as $row) {

                $playlist = new Playlist($pdo, $row);

                echo "<div class='gridViewItem' data-playlist-id='" . $playlist->getId() . "' role='link' tabindex='0'>
                            <div class='playlistImage'><img src='assets/images/icons/playlistGreen.png' alt='Playlist icon'></div>
                            <div class='gridViewInfo'>" . $playlist->getName() . "</div>
                    </div>";
            }
        ?>

    </div>
</div>


