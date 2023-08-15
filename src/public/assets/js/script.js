(function ($) {

    let me = {};

    me.selectors = {
        'mainContent': '#mainContent',
        'logo': '.logo',
        'browse': '.navItemLink.browse',
        'yourMusic': '.navItemLink.yourMusic',
        'profile': '.navItemLink.profile',
        'search': '.navItemLink.search'
    };

    window.openPage = function (url) {

        if (typeof timer !== 'undefined' && timer !== null) {
            clearTimeout(timer);
        }

        if (url.indexOf("?") === -1) {
            url = url + "?";
        }

        let encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
        $(me.selectors.mainContent).load(encodedUrl);
        $("body").scrollTop(0);
        history.pushState(null, null, url);
    }

    me.openIndexPage = function () {
        openPage('index.php');
    }

    me.openBrowsePage = function () {
        openPage('browse.php');
    }

    me.openYourMusicPage = function () {
        openPage('yourMusic.php');
    }

    me.openProfilePage = function () {
        openPage('settings.php');
    }

    me.openSearchPage = function () {
        openPage('search.php');
    }

    me.eventListeners = function () {
        $(me.selectors.logo).on('click', me.openIndexPage);
        $(me.selectors.browse).on('click', me.openBrowsePage);
        $(me.selectors.yourMusic).on('click', me.openYourMusicPage);
        $(me.selectors.profile).on('click', me.openProfilePage);
        $(me.selectors.search).on('click', me.openSearchPage);
    }

    me.init = function () {
        me.eventListeners();
    }

    $(document).ready(me.init);

})(jQuery)
