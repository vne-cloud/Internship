function compact(){
	if ($(window).width() <= 1660) {
		$('body').addClass('menuCompact');
	}
	else {
		if (!$('body').hasClass('menuCompactUser')) {
			$('body').removeClass('menuCompact');
		}
	}
}
compact();