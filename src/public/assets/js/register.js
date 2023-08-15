(function ($) {
    let me = {};

    me.selectors = {
        'hideLogin': '#hideLogin',
        'hideRegister': '#hideRegister',
        'loginForm': '#loginForm',
        'registerForm': '#registerForm',
    }

    me.eventListeners = function () {
        $(me.selectors.hideLogin).click(function () {
            $(me.selectors.loginForm).hide();
            $(me.selectors.registerForm).show();
        });

        $(me.selectors.hideRegister).click(function () {
            $(me.selectors.loginForm).show();
            $(me.selectors.registerForm).hide();
        });
    }

    me.init = function () {
        me.eventListeners();
    }

    $(document).ready(me.init);

})(jQuery)