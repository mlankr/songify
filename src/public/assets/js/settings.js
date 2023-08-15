(function ($) {

    let me = {};

    me.selectors = {
        'mainContent': '#mainContent',
        'userDetailsButton': '#userDetails',
        'logoutButton': '#logout'
    };

    me.attributes = {};

    me.showUserDetails = function () {
        openPage("userDetails.php");
    }

    me.logout = function () {
        $.post("includes/handlers/ajax/logout.php", function () {
            location.reload();
        })
    }

    me.eventListeners = function () {
        $(me.selectors.mainContent).on('click', me.selectors.userDetailsButton, me.showUserDetails);
        $(me.selectors.mainContent).on('click', me.selectors.logoutButton, me.logout);

    }

    me.init = function () {
        me.eventListeners();
    }

    $(document).ready(me.init);
})(jQuery)