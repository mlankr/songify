(function ($) {

    let me = {};

    me.selectors = {
        'mainContent': '#mainContent',
        'searchBar': '.searchInput',
        'artistNameInSearchPage': '.artistsContainer .searchResultRow .artistName span',
        'albumInSearchPage': '.gridViewContainer .gridViewItem'
    }

    me.attributes = {
        'artistIdInSearchPage': 'data-search-artist-id',
        'albumIdInSearchPage': 'data-search-album-id'
    }

    // set the same input value with the cursor at the end of the value on each page refresh
    $(me.selectors.searchBar).focus();
    let search = $(me.selectors.searchBar).val();
    $(me.selectors.searchBar).val('');
    $(me.selectors.searchBar).val(search);

    window.timer = 0;

    $(me.selectors.searchBar).on('keyup', function () {
        // refreshes page on each time user types a word after 2000ms (2s)

        clearTimeout(timer);

        timer = setTimeout(function () {
            let value = $(me.selectors.searchBar).val();
            openPage("search.php?term=" + value);
        }, 2000);
    })

    $(me.selectors.mainContent).on('click', me.selectors.artistNameInSearchPage, function () {
        let artistId = $(this).attr(me.attributes.artistIdInSearchPage);
        if (!artistId) return;
        openPage("artist.php?id=" + artistId);
    });

    $(me.selectors.mainContent).on('click', me.selectors.albumInSearchPage, function () {
        let albumId = $(this).attr(me.attributes.albumIdInSearchPage);
        if (!albumId) return;
        openPage("album.php?id=" + albumId);
    });

})(jQuery)