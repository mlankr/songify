(function ($) {

    let me = {};

    me.selectors = {
        'mainContent': '#mainContent',
        'browse': '.albumGrid.browseAlbum'
    };

    me.attributes = {
        'albumId': 'data-album-id'
    };

    me.browseAlbums = function () {
        let albumId = $(this).attr(me.attributes.albumId);
        if (!albumId) return;
        openPage("album.php?id=" + albumId);
    }

    me.eventListeners = function () {
        $(me.selectors.mainContent).on('click', me.selectors.browse, me.browseAlbums);

    }

    me.init = function () {
        me.eventListeners();
    }

    $(document).ready(me.init);
})(jQuery)