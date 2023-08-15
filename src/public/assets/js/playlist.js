(function ($) {

    let me = {};

    me.selectors = {
        'mainContent': '#mainContent',
        'deletePlaylistButton': '.deletePlaylist',
        'removeFromPlaylist': '.removeFromPlaylist'
    };

    me.attributes = {
        'playlistId': 'data-playlistId',
        'songToRemoveFromPlaylist': 'data-removePlaylistId'
    }


    me.deletePlaylist = function (playlistId) {
        $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId})
            .done(function (data) {
                data = JSON.parse(data);
                if (data.error) {
                    console.error('error', data.error);
                    return;
                }
                // successful response
                openPage("playlist.php");
            });
    }

    me.removeFromPlaylist = function (element, playlistId) {
        let songId = element.siblings(".songId").val();
        if (playlistId && songId) {
            $.post("includes/handlers/ajax/removeFromPlaylist.php", {playlistId, songId})
                .done(function (data) {
                    if (data.error) {
                        data = JSON.parse(data);
                        console.log('error', data.error);
                        return;
                    }
                    //success
                    openPage("playlist.php?id=" + playlistId);
                })
        }
    }

    me.handlePlaylistDeletion = function () {
        let playlistId = $(me.selectors.mainContent).find(me.selectors.deletePlaylistButton).attr(me.attributes.playlistId);
        if (playlistId) {
            me.deletePlaylist(playlistId);
        }
    }

    me.handleRemoveFromPlaylist = function () {
        let selectedDiv = $(me.selectors.mainContent).find(me.selectors.removeFromPlaylist);
        let playlistId = selectedDiv.attr(me.attributes.songToRemoveFromPlaylist);
        if (playlistId) {
            me.removeFromPlaylist(selectedDiv, playlistId);
        }
    }

    me.promptModal = function () {
        let args = {
            title: 'Are you sure you want to delete the playlist?',
            dismissButtonLabel: 'CANCEL',
            confirmButtonLabel: 'DELETE',
            dismissButtonClasses: 'button-main-animate',
            confirmButtonClasses: 'button-red',
            customEvent: 'delete:playlist'
        }
        initModal(args);
    }

    me.eventListeners = function () {
        $(me.selectors.mainContent).on('click', me.selectors.deletePlaylistButton, me.promptModal);
        $(me.selectors.mainContent).on('delete:playlist', me.handlePlaylistDeletion);
        $(me.selectors.mainContent).on('click', me.selectors.removeFromPlaylist, me.handleRemoveFromPlaylist);
    }

    me.init = function () {
        me.eventListeners();
    }

    $(document).ready(me.init);
})(jQuery)