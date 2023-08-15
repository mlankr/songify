<?php

    $songQuery = "SELECT id FROM songs ORDER BY RAND() LIMIT 10";
    $songQueryPrepareQuery = $pdo->prepare($songQuery);
    $songQueryPrepareQuery->execute();
    $songs = $songQueryPrepareQuery->fetchAll(PDO::FETCH_COLUMN, 0);
    $jsonArray = json_encode($songs);
?>

<script>
    $(document).ready(function () {
        window.newPlaylist = <?php echo $jsonArray; ?>;
        window.currentPlayList = [];
        window.shufflePlaylist = [];
        window.audioElement = new $.Audio();
        window.mouseDown = false;
        window.currentIndex = 0;
        window.repeat = false;
        window.shuffle = false;
        setTrack(newPlaylist[0], newPlaylist, false);

        let nowPlayingBarContainer = $("#nowPlayingBar");
        let progressBar = $(".playbackBar .progressBar");
        let volumeBar = $(".volumeBar .progressBar");

        nowPlayingBarContainer.on("mousedown touchstart mousemove touchmove", function (e) {
            e.preventDefault();
        });


        progressBar.on("mousedown", function () {
            mouseDown = true;
        });

        progressBar.on("mousemove", function (e) {
            if (mouseDown) {
                // Set time of song, depending on position of the mouse
                timeFromOffset(e, this);
                if (audioElement.audio.paused) {
                    audioElement.pauseSong();
                }
            }
        });

        progressBar.on("mouseup", function (e) {
            timeFromOffset(e, this);
            if (!audioElement.audio.paused) {
                audioElement.playSong();
            }
        });

        volumeBar.on("mousedown", function () {
            mouseDown = true;
        });

        volumeBar.on("mousemove", function (e) {
            if (mouseDown) {
                let percentage = (e.offsetX / $(this).width());
                if (percentage >= 0 && percentage <= 1) {
                    audioElement.audio.volume = percentage;
                }
            }
        });

        volumeBar.on("mouseup", function (e) {
            let percentage = (e.offsetX / $(this).width());
            if (percentage >= 0 && percentage <= 1) {
                audioElement.audio.volume = percentage;
            }
        });

        $(document).on("mouseup", function (e) {
            mouseDown = false;
        });

    });

    function timeFromOffset(mouseEvent, progressBar) {
        let percentage = (mouseEvent.offsetX / $(progressBar).width()) * 100;
        let seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            let j = Math.floor(Math.random() * (i + 1));
            let temp = array[i];
            array[i] = array[j];
            array[j] = temp;
        }
    }

    function setTrack(trackId, newPlaylist, play) {
        if (newPlaylist !== currentPlayList) {
            currentPlayList = newPlaylist;
            shufflePlaylist = currentPlayList.slice();
            shuffleArray(shufflePlaylist);
        }

        if (shuffle) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        } else {
            currentIndex = currentPlayList.indexOf(trackId);
        }

        audioElement.pauseSong();

        $.post("includes/handlers/ajax/getSongJSON.php", {songId: trackId}, function (data) {

            const track = JSON.parse(data);
            $('.trackInfo .trackName span').text(track.title);

            $.post("includes/handlers/ajax/getArtistJSON.php", {artistId: track.artist}, function (data) {
                const artist = JSON.parse(data);
                $(".trackInfo .artistName span").text(artist.name).attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
            });

            $.post("includes/handlers/ajax/getAlbumJSON.php", {albumId: track.album}, function (data) {
                const album = JSON.parse(data);
                $(".content .albumLink img").attr({
                    src: album.artworkPath,
                    onclick: "openPage('album.php?id=" + album.id + "')"
                });
                $('.trackInfo .trackName span').attr("onclick", "openPage('album.php?id=" + album.id + "')");
            });

            audioElement.setTrack(track);
            if (play) {
                audioElement.playSong();
            }
        });
    }
</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content playerControls">
                    <span class="albumLink">
                        <img role="link" tabindex="0" src="" class="albumArtWork" alt="">
                    </span>
                <div class="trackInfo">
                    <span class="trackName"><span role="link" tabindex="0"></span></span>
                    <span class="artistName"><span role="link" tabindex="0"></span></span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle button">
                        <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>
                    <button class="controlButton previous" title="Previous button">
                        <img src="assets/images/icons/previous.png" alt="Previous">
                    </button>
                    <button class="controlButton play playBtn-nowPlaying" title="Play button">
                        <img src="assets/images/icons/play.png" alt="Play">
                    </button>
                    <button class="controlButton pause pauseBtn-nowPlaying" title="Pause button" style="display: none">
                        <img src="assets/images/icons/pause.png" alt="Pause">
                    </button>
                    <button class="controlButton next" title="Next button">
                        <img src="assets/images/icons/next.png" alt="Next">
                    </button>
                    <button class="controlButton repeat" title="Repeat button">
                        <img src="assets/images/icons/repeat.png" alt="Repeat">
                    </button>
                </div>

                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress songProgress"></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">0.00</span>
                </div>

            </div>
        </div>
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume button">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress volumeProgress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
