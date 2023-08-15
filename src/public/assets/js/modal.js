(function ($) {

    let me = {};

    me.selectors = {
        'mainContent': '#mainContent',
        'modalContainer': '.modalContainer',
        'modal': '.modal',
        'modalOverlay': '.modalOverlay',
        'modalTitle': '.modalTitle',
        'modalBody': '.modalBody',
        'inputField': '.inputField',
        'inputError': '.inputError',
        'dismissButton': '.dismissButton',
        'confirmButton': '.confirmButton',
        'closeButton': '.close'
    };

    me.customEvent = '';

    window.initModal = function (args) {
        if (!args) return;

        if (args.title) {
            $(me.selectors.modalTitle).text(args.title);
        }

        if (args.inputPlaceholder) {
            $(me.selectors.inputField).attr('placeholder', args.inputPlaceholder);

            if (args.inputError) {
                $(me.selectors.inputError).text(args.inputError);
            }
        } else {
            $(me.selectors.modalBody).remove();
        }

        if (args.confirmButtonLabel) {
            $(me.selectors.confirmButton).text(args.confirmButtonLabel);
        }

        if (args.dismissButtonLabel) {
            $(me.selectors.dismissButton).text(args.dismissButtonLabel);
        }

        if (args.dismissButtonClasses) {
            $(me.selectors.dismissButton).addClass(args.dismissButtonClasses);
        }

        if (args.confirmButtonClasses) {
            $(me.selectors.confirmButton).addClass(args.confirmButtonClasses);
        }

        if (args.customEvent) {
            me.customEvent = args.customEvent;
        }

        me.showModal();
    }

    // open the modal
    me.showModal = function () {
        $(me.selectors.modalContainer).show();
        $(me.selectors.inputField).focus();
    }

    // close the modal on clicking <span> (x)
    me.closeModal = function () {
        $(me.selectors.modalContainer).hide();
    }

    // close the modal on clicking outside
    me.closeModalOnOutsideClick = function (event) {
        event.stopPropagation();
        if ($(event.target).data('backdrop')) {
            me.closeModal();
        }
    }

    // validate submission data & show/hide error message
    me.validateSubmission = function (inputValue) {
        if (inputValue.trim().length > 0) {
            $(me.selectors.inputError).removeClass('error').hide();
            return true;
        }
        $(me.selectors.inputError).addClass('error').show();
        return false;
    }

    me.handleInputChange = function (event) {
        event.preventDefault();
        if ($(me.selectors.modalBody)[0]) {
            let inputValue = $(this).val();
            me.validateSubmission(inputValue);
        }
    }

    me.onSubmission = function (event) {
        event.preventDefault();

        if ($(me.selectors.modalBody)[0]) {

            let modal = $(this).closest(me.selectors.modal),
                inputValue = modal.find(me.selectors.inputField).val();

            if (!me.validateSubmission(inputValue)) {
                return;
            }

            if (me.customEvent) {
                $(me.selectors.mainContent).trigger(me.customEvent, {name: inputValue});
            }
        } else {
            $(me.selectors.mainContent).trigger(me.customEvent);
        }
        me.handleAfterSubmission();
    }

    me.handleAfterSubmission = function () {
        if ($(me.selectors.modalBody)[0]) $(me.selectors.inputField).text('');
        me.closeModal();
    }

    me.eventListeners = function () {
        $(me.selectors.mainContent).on('click', me.selectors.closeButton, me.closeModal);
        $(me.selectors.mainContent).on('click', me.selectors.confirmButton, me.onSubmission);
        $(me.selectors.mainContent).on('click', me.selectors.dismissButton, me.closeModal);
        $(me.selectors.mainContent).on('keyup', me.selectors.inputField, me.handleInputChange);
        $(me.selectors.mainContent).on('click', me.selectors.modalOverlay, me.closeModalOnOutsideClick);
    }

    me.init = function () {
        me.eventListeners();
    }

    $(document).ready(me.init);
})(jQuery)