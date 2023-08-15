(function ($) {

    let me = {};

    me.selectors = {
        'mainContent': '#mainContent',
        'saveEmailButton': '.saveEmailButton',
        'savePasswordButton': '.savePasswordButton',
        'spanEmail': '.emailMessage',
        'spanPassword': '.passwordMessage',
        'emailInput': '.email',
        'oldPasswordInput': '#oldPassword',
        'newPasswordInput': '#newPassword1',
        'confirmPasswordInput': '#newPassword2'
    };

    me.showSpan = function (element, message, className) {
        $(element).text(message);
        $(element).addClass(className);
    }

    me.hideSpan = function (element, className) {
        $(element).text("");
        $(element).removeClass(className);
    }

    me.handleOutsideClick = function () {
        me.hideSpan(me.selectors.spanEmail, 'error');
        me.hideSpan(me.selectors.spanPassword, 'error');
        me.hideSpan(me.selectors.spanEmail, 'success');
        me.hideSpan(me.selectors.spanPassword, 'success');
    }

    me.validateInput = function () {
        let self = $(this);
        let data = self.val();
        if (data.trim().length <= 0) {
            if (self.hasClass('email')) {
                me.showSpan(me.selectors.spanEmail, "Email cannot be empty!", 'error');
            } else {
                me.showSpan(me.selectors.spanPassword, "Password cannot be empty!", 'error');
            }
        } else {
            if (self.hasClass('email')) {
                me.hideSpan(me.selectors.spanEmail, 'error');
            } else {
                me.hideSpan(me.selectors.spanPassword, 'error');
            }
        }
    }

    me.updateEmail = function (e) {
        e.preventDefault();
        e.stopPropagation();
        let email = $(me.selectors.emailInput).val().trim();
        if (email.length > 0) {
            $.post("includes/handlers/ajax/updateEmail.php", {email, username: userLoggedIn})
                .done(function (data) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.error) {
                        $(me.selectors.spanEmail).text(data.error).addClass('error');
                        return;
                    }

                    me.showSpan(me.selectors.spanEmail, data.success, 'success');
                });
        } else {
            me.showSpan(me.selectors.spanEmail, 'Email cannot be empty!', 'error');
        }
    }

    me.updatePassword = function (e) {
        e.preventDefault();
        e.stopPropagation();
        let oldPassword = $(me.selectors.oldPasswordInput).val().trim();
        let newPassword = $(me.selectors.newPasswordInput).val().trim();
        let confirmPassword = $(me.selectors.confirmPasswordInput).val().trim();
        if (oldPassword.length >= 5 && oldPassword.length < 30 && newPassword === confirmPassword) {
            $.post("includes/handlers/ajax/updatePassword.php", {
                oldPassword,
                newPassword,
                confirmPassword,
                username: userLoggedIn
            })
                .done(function (data) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.error) {
                        $(me.selectors.spanPassword).text(data.error).addClass('error');
                        return;
                    }

                    me.showSpan(me.selectors.spanPassword, data.success, 'success');
                });
        } else {
            if (newPassword !== confirmPassword) {
                me.showSpan(me.selectors.spanPassword, "New passwords don't match!", 'error');
            } else {
                me.showSpan(me.selectors.spanPassword, 'Password must be between 5 and 30 characters!', 'error');
            }
        }
    }


    me.eventListeners = function () {
        $(me.selectors.mainContent).on('click', me.selectors.saveEmailButton, me.updateEmail);
        $(me.selectors.mainContent).on('click', me.selectors.savePasswordButton, me.updatePassword);
        $(me.selectors.mainContent).on('keyup', me.selectors.emailInput, me.validateInput);
        $(me.selectors.mainContent).on('keyup', me.selectors.oldPasswordInput, me.validateInput);
        $(me.selectors.mainContent).on('keyup', me.selectors.newPasswordInput, me.validateInput);
        $(me.selectors.mainContent).on('keyup', me.selectors.confirmPasswordInput, me.validateInput);
        $(me.selectors.mainContent).on('blur', 'input', me.handleOutsideClick);
    }

    me.init = function () {
        me.eventListeners();
    }

    $(document).ready(me.init);
})
(jQuery)