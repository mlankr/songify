(function ($) {

    let me = {};

    me.selectors = {
        'play': '.play',
        'pause': '.pause',
        'prev': '.previous',
        'next': '.next',
        'repeat': '.repeat',
        'repeatImg': '.repeat img',
        'volume': '.volume',
        'volumeImg': '.volume img',
        'shuffle': '.shuffle',
        'shuffleImg': '.shuffle img',
        'bottomPlayBtn': '.playBtn-nowPlaying',
        'bottomPauseBtn': '.pauseBtn-nowPlaying',
        'controlButton': '.controlButton',
        'songProgress': '.songProgress',
        'volumeProgress': '.volumeProgress',
        'progressTime': '.progressTime',
        'current': '.current',
        'remaining': '.remaining'
    };

    $.Audio = function () {
        this.currentlyPlaying = {};
        this.audio = document.createElement('audio');
    }

    $.Audio.prototype = {
        setTrack: function (track) {
            this.curretlyPlaying = track;
            this.audio.src = track.path;
        },

        playSong: function () {
            if (this.audio.currentTime === 0) {
                $.post("includes/handlers/ajax/updatePlays.php", {songId: this.curretlyPlaying.id});
            }
            $(me.selectors.bottomPlayBtn).hide();
            $(me.selectors.bottomPauseBtn).show();
            this.audio.play();
        },

        pauseSong: function () {
            $(me.selectors.bottomPauseBtn).hide();
            $(me.selectors.bottomPlayBtn).show();
            this.audio.pause();
        },

        nextSong: function () {
            if (repeat === true) {
                this.setTime(0);
                this.playSong();
                return;
            }
            if (currentIndex === currentPlayList.length - 1) {
                currentIndex = 0;
            } else {
                currentIndex++;
            }
            const trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlayList[currentIndex];
            setTrack(trackToPlay, currentPlayList, true);
        },

        prevSong: function () {
            if (this.audio.currentTime >= 3 || currentIndex === 0) {
                this.setTime(0);
            } else {
                currentIndex--;
                setTrack(currentPlayList[currentIndex], currentPlayList, true);
            }
        },

        repeatSong: function () {
            repeat = !repeat;
            const imageName = repeat ? "repeat-active.png" : "repeat.png";
            $(me.selectors.repeatImg).attr("src", "assets/images/icons/" + imageName);
        },

        muteSong: function () {
            this.audio.muted = !this.audio.muted;
            const imageName = this.audio.muted ? "volume-mute.png" : "volume.png";
            $(me.selectors.volumeImg).attr("src", "assets/images/icons/" + imageName);
        },

        shuffleSong: function () {
            shuffle = !shuffle;
            const imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
            $(me.selectors.shuffleImg).attr("src", "assets/images/icons/" + imageName);

            if (shuffle) {
                // randomize playlist
                shuffleArray(shufflePlaylist);
                currentIndex = shufflePlaylist.indexOf(audioElement.curretlyPlaying.id);

            } else {
                // shuffle deactivated, go to regular playlist
                currentIndex = currentPlayList.indexOf(audioElement.curretlyPlaying.id);
            }
        },

        setTime: function (seconds) {
            this.audio.currentTime = seconds;
        }
    }

    me.formatTime = function (seconds) {
        let time = Math.round(seconds);
        let minutes = Math.floor(time / 60);
        let secondsRemaining = time - (minutes * 60);

        return minutes + ':' + (secondsRemaining < 10 ? "0" : "") + secondsRemaining;
    }

    me.updateVolumeInProgressBar = function () {
        let songVolume = audioElement.audio.volume * 100;
        $(me.selectors.volumeProgress).width(songVolume + '%');
    }

    me.updateTimeInProgressBar = function (audio) {
        $(me.selectors.current).text(me.formatTime(audio.currentTime));
        // $(me.selectors.remaining).text(me.formatTime(audio.duration - audio.currentTime));

        let progress = (audio.currentTime / audio.duration) * 100;
        $(me.selectors.songProgress).width(progress + '%');
    }

    me.onTimeUpdate = function () {
        if (this.duration) {
            me.updateTimeInProgressBar(this);
        }
    }

    me.updateRemainingTime = function () {
        $(me.selectors.remaining).text(me.formatTime(audioElement.audio.duration));
    }

    me.onShuffleSong = function () {
        audioElement.shuffleSong();
    }

    me.onMuteSong = function () {
        audioElement.muteSong();
    }

    me.onRepeatSong = function () {
        audioElement.repeatSong();
    }

    me.onNextSong = function () {
        audioElement.nextSong();
    }

    me.onPrevSong = function () {
        audioElement.prevSong();
    }
    me.onPausingSong = function () {
        audioElement.pauseSong();
    }

    me.onPlayingSong = function () {
        audioElement.playSong();
    }

    me.eventListeners = function () {
        $(me.selectors.play).on('click', me.onPlayingSong);
        $(me.selectors.pause).on('click', me.onPausingSong);
        $(me.selectors.next).on('click', me.onNextSong);
        $(me.selectors.prev).on('click', me.onPrevSong);
        $(me.selectors.repeat).on('click', me.onRepeatSong);
        $(me.selectors.volume).on('click', me.onMuteSong);
        $(me.selectors.shuffle).on('click', me.onShuffleSong);
        $(audioElement.audio).on('canplay', me.updateRemainingTime);
        $(audioElement.audio).on('ended', me.onNextSong);
        $(audioElement.audio).on('timeupdate', me.onTimeUpdate);
        $(audioElement.audio).on('volumechange', me.updateVolumeInProgressBar);
    }

    me.init = function () {
        me.eventListeners();
        me.updateVolumeInProgressBar();
    }

    $(document).ready(me.init);
})(jQuery)