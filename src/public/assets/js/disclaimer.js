(function ($) {

	let me = {};

	me.selectors = {
		'mainContent': '#mainContent',
		'disclaimer': '.disclaimer'
	};

	me.showDisclaimer = function () {
		openPage("disclaimer.php?");
	}

	me.eventListeners = function () {
		$(me.selectors.mainContent).on('click', me.selectors.disclaimer, me.showDisclaimer);

	}

	me.init = function () {
		me.eventListeners();
	}

	$(document).ready(me.init);
})(jQuery)