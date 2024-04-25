/***************** INPUTS CHECK *******************/

function valid(elements) {
	next = true;
	elements.removeClass('inputs-red');
	elements.each(function(){
		var val = $(this).val();
		if (val == '') {
			$(this).addClass('inputs-red');
			next = false;
		}
	});
	return next;
}

/***************** MOD *******************/

$('body').on('click', '#close, #black, #btn-close', function(){
	win_close();
});
function win_auto() {
	var w = $('#mod').width();
	w1 = w/2-w;
	$('#mod').css({'margin-left' : w1});
	var h = $('#mod').height();
	h1 = h/2-h;
	w = $(window).height();
	if (h > w) {
		$('#mod').css({'top' : '0px'});
		$('#mod').css({'margin-top' : '35px'});
		$('body').css('overflow', 'hidden');
	}
	else {
		$('#mod').css({'top' : '50%'});
		$('#mod').css({'margin-top' : h1});
		$('body').css('overflow', 'auto');
	}
}
function win(html){
	$('.top-menu-black').fadeOut(300);
	$('#black-wrap').fadeIn(300);
	$('#mod').addClass('anime-mod-show');
	$('#modbox').html(html);
	win_auto();
}
function win_close(){
	$('#mod').removeClass('anime-mod-show');
	$('#modbox').removeClass('modbox-city');
	$('#black-wrap').fadeOut(300);
}

/******************* MASK ********************/

$('.input-phone').mask('+7 (999) 999-99-99');

/******************* DOTS ********************/

$('.dot').dotdotdot({});

/***************** DATEPICKER *****************/

if ($('.datepicker').length > 0) {
	$.datepicker.setDefaults(
		$.extend($.datepicker.regional['ru'])
	);
	$( function() {
		$('.datepicker').datepicker({
			numberOfMonths: 1,
			afterShow: function () {},
			onSelect : function() {
				$('.datepicker').each(function(){
					var val = $(this).val();
					var parent = $(this).parent();
					if (val == '') $('.placeholder', parent).removeClass('placeholder-act');
					else $('.placeholder', parent).addClass('placeholder-act');
				});
				profile_edit_save(0);
			}
		});
	});
	$('.datepicker').mask('99.99.9999');
}

/* --- PLACEHOLDER --- */

$('body').on('focus', '.place-box > input', function(){
	var parent = $(this).parent();
	$('.placeholder', parent).addClass('placeholder-act');
});

$('body').on('blur', '.place-box > input', function(){
	var val = $(this).val();
	var parent = $(this).parent();
	if (val == '') {
		$('.placeholder', parent).removeClass('placeholder-act');
	}
});

if ($('.place-box > input').length > 0) {
	$('.place-box > input').each(function(){
		var val = $(this).val();
		var parent = $(this).parent();
		if (val != '') {
			$('.placeholder', parent).addClass('placeholder-act');
		}
	});
}

/***************** BANNERS *******************/

if ($('.banners-slick').length > 0) {
	$('.banners-slick').slick({
		dots: true,
		draggable: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		dotsClass: 'banners-dots',
		infinite: true,
		speed: 600,
		autoplay: true,
		autoplaySpeed: 4000,
		vertical: true,
		verticalSwiping: true,
	});
}

/* --- MESSAGE --- */

setTimeout(function(){
	if ($('.message').length > 0) {
		var message = $('.message').html().trim();
		if (message != '') {
			message = "<div class='win-message'>"+message+"</div>";
			win(message);
		}
	}
}, 100);

/* --- // --- */

/********************************************/

