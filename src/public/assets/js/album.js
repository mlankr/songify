(function ($) {

    let me = {};

    me.selectors = {
        'mainContent': '#mainContent',
        'playAlbumSong': '.trackCount .play',
        'selectPlaylist': '#selectPlaylist',
        'optionsButton': '.optionsButton',
        'optionsMenu': '.optionsMenu'
    };

    me.attributes = {
        'songId': 'data-song-id'
    };

    me.playSong = function () {
        let songId = $(this).attr(me.attributes.songId);
        if (!songId) return;
        setTrack(songId, tempPlaylist, true);
    }

    me.showMenu = function () {
        let songId = $(this).prevAll('.songId').val();
        let menu = $(me.selectors.optionsMenu);

        menu.find('.songId').val(songId);

        let scrollTop = $(window).scrollTop(); // distance from top of window to top of document
        let elementOffset = $(this).offset().top; // distance from top of document
        let top = elementOffset - scrollTop;
        let left = $(this).position().left;

        menu.css({'top': top + 'px', 'left': left + 'px', display: 'inline'})
    }

    me.hideMenu = function () {
        let menu = $(me.selectors.optionsMenu);
        if (menu && menu.css('display') !== 'none') {
            menu.hide();
        }
    }

    me.hideMenuOnOutsideClick = function (e) {
        let target = $(e.target);
        if (!target.hasClass('item') && !target.hasClass('optionsButton')) {
            me.hideMenu();
        }
    }

    me.addToPlaylist = function (e) {
        e.preventDefault();
        e.stopPropagation();
        let self = $(this);
        let playlistId = self.val();
        let songId = self.parent().find('.songId').val();
        if (playlistId && songId) {
            $.post("includes/handlers/ajax/addToPlaylist.php", {playlistId, songId})
                .done(function (data) {
                    if (data.error) {
                        data = JSON.parse(data);
                        console.log('error', data.error);
                        return;
                    }
                    //success
                    me.hideMenu();
                    self.val('');
                })
        }
    }

    me.eventListeners = function () {
        $(me.selectors.mainContent).on('click', me.selectors.playAlbumSong, me.playSong);
        $(me.selectors.mainContent).on('click', me.selectors.optionsButton, me.showMenu);
        $(window).on('scroll', me.hideMenu);
        $(document).on('click', me.hideMenuOnOutsideClick);
        $(document).on('change', me.selectors.selectPlaylist, me.addToPlaylist);

    }

    me.init = function () {
        me.eventListeners();
    }

    $(document).ready(me.init);
})(jQuery)