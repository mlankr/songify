(function ($) {

    let me = {};

    me.selectors = {
        'mainContent': '#mainContent',
        'playButtonInArtist': '.playButtonInArtist'
    };

    me.playFirstSong = function () {
        setTrack(tempPlaylist[0], tempPlaylist, true);
    }


    me.eventListeners = function () {
        $(me.selectors.mainContent).on('click', me.selectors.playButtonInArtist, me.playFirstSong);
    }

    me.init = function () {
        me.eventListeners();
    }

    $(document).ready(me.init);
})(jQuery)