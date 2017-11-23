
(function($) {

'use strict';

$(function() {
	var active1 = false;
	var active2 = false;
	var active3 = false;

	$('.ub-menu-parent').on('mousedown touchstart', function() {
		if (!active1) $(this).find('.ub-menu-index').css({'background-color': 'gray', 'transform': 'translate(0px, 75px)'});
		else $(this).find('.ub-menu-index').css({'background-color': 'dimGray', 'transform': 'none'});
		if (!active2) $(this).find('.ub-menu-categories').css({'background-color': 'gray', 'transform': 'translate(50px, 50px)'});
		else $(this).find('.ub-menu-categories').css({'background-color': 'darkGray', 'transform': 'none'});
		if (!active3) $(this).find('.ub-menu-archive').css({'background-color': 'gray', 'transform': 'translate(75px, 0px)'});
		else $(this).find('.ub-menu-archive').css({'background-color': 'silver', 'transform': 'none'});

		active1 = !active1;
		active2 = !active2;
		active3 = !active3;
	});
});

})(jQuery);
