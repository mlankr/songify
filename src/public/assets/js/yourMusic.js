(function ($) {

    let me = {};

    me.selectors = {
        'mainContent': '#mainContent',
        'playlist': '.gridViewItem',
        'playlistButton': '.playlistButton'
    };

    me.attributes = {
        'playlistId': 'data-playlist-id'
    }

    me.createPlaylist = function (playlistName) {
        $.post("includes/handlers/ajax/createPlaylist.php", {playlistName, username: userLoggedIn})
            .done(function (data) {
                data = JSON.parse(data);
                if (data.error) {
                    console.error('error', data.error);
                    return;
                }
                // successful response
                openPage("yourMusic.php");
            });
    }

    me.promptModal = function () {
        let args = {
            title: 'Please provide a playlist name',
            inputPlaceholder: 'Playlist name',
            inputError: 'Playlist name cannot be empty',
            dismissButtonLabel: 'CANCEL',
            confirmButtonLabel: 'CREATE',
            dismissButtonClasses: 'button-main-animate',
            confirmButtonClasses: 'button-green',
            customEvent: 'create:playlist'
        }
        initModal(args);
    }

    me.handlePlaylistCreation = function (e, data) {
        if (data.name) {
            me.createPlaylist(data.name);
        }
    }

    me.openPlaylist = function (e) {
        e.preventDefault();
        if ($(this).attr(me.attributes.playlistId)) {
            openPage("playlist.php?id=" + $(this).attr(me.attributes.playlistId));
        }
    }

    me.eventListeners = function () {
        $(me.selectors.mainContent).on('click', me.selectors.playlistButton, me.promptModal);
        $(me.selectors.mainContent).on('create:playlist', me.handlePlaylistCreation);
        $(me.selectors.mainContent).on('click', me.selectors.playlist, me.openPlaylist);
    }

    me.init = function () {
        me.eventListeners();
    }

    $(document).ready(me.init);
})(jQuery)