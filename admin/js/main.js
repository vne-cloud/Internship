anime();

function win_auto() {
	var w = $('#mod').width();
	w1 = w/2-w;
	$('#mod').css({'margin-left' : w1});
	var h = $('#mod').height();
	h1 = h/2-h;
	$('#mod').css({'margin-top' : h1});
}
$('body').on('click', '.close, #black', function(){
	$('.notice').hide();
	$('#black').hide();
	$('#mod').hide();
});
$('body').on('click', '.button_alert', function(){
	$('.notice').hide();
	$('#black').hide();
});
$('.dialog').click(function () {
	$('#black').fadeIn(100);
	$('#mod').fadeIn(100);

	var id = '#' + this.id + ' .m';
	var ht = $(id).html();
	$('#modbox').html(ht);

	win_auto();
});

function search_form(step){
	var form = $('.search_form').serialize()+'&search_form=1'+'&step='+step;
	$('.search_loading').show();
	$.ajax({
		url: '/admin/admin_ajax.php',
		type: 'POST',
		data: form,
		success: function(html){
			if (html != '') $('.api_form').html(html);
			$('.search_loading').hide();
		}
	});
}

$(document).ready(function(){

	setTimeout(function(){
		$('.notice').fadeOut(150);
	}, 1100);

	$('body').on('click', '.save', function(){
		$('.formbox_submit input[type=submit]').click();
	});

	$('body').on('click', '.admin_menu_link', function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		$.ajax({
			url: '/admin/admin_ajax.php',
			type: 'POST',
			data: {
				'admin_structure' : '1'
				, 'val' : '0'
			},
			success: function(html){
				top.location.href = href;
			}
		});
	});

	/* --- ALL --- */

	$('.filt-all').change(function(){
		$('.submit-all').click();
	});

	$('.button-all').click(function(){
		$('.submit-all').click();
	});

	$('.delete-all').click(function(e) {
		var i = $(this).attr('href');
		var text = 'Вы уверены что хотите удалить запись?';
		if (confirm(text)) {
			top.location.href=i;
		}
		else {
			e.preventDefault();
			return false;
		}
	});

	$(document).ready(function(){
		$('.tablesorter').tablesorter({
			widthFixed: true,
			sortList: [[0,1]]
		});
	});

	/* --- // --- */
});

function body(){
	var w = Number($(window).height());
	var left = Number($('.left').height());
	if (left > w) w = left;
	var h = Number($('.admin_header').outerHeight());
	var a = w - h;
	$('.all, .list').css('min-height', a+'px');

	if ($('.vrow>.menu').css('display') == 'none') {
		if ($('.pageArrow').css('display') == 'block') {
			var t = Number($('.pageArrow').offset().top);
			var m = t - h + 7;
			if (m > 0) {
				$('.leftLinkBtn').css('margin-top', m+'px');
				$('.leftLinkBtn').addClass('leftLinkBtnShow');
			}
		}

		if ($('.leftLinkAct').css('display') == 'block') {
			var t = Number($('.leftLinkAct').offset().top);
			var m = t - h + 16;
			if (m > 0) {
				$('.leftLinkBtn').css('margin-top', m+'px');
				$('.leftLinkBtn').addClass('leftLinkBtnShow');
			}
		}
	}
	else {
		if ($('.vrow>.menu .pageArrow').css('display') == 'block') {
			var t = Number($('.vrow>.menu .pageArrow').offset().top);
			var m = t - h + 7;
			if (m > 0) {
				$('.leftLinkBtn').css('margin-top', m+'px');
				$('.leftLinkBtn').addClass('leftLinkBtnShow');
			}
		}
		if ($('.vrow>.menu .leftLinkAct').css('display') == 'block') {
			var t = Number($('.vrow>.menu .leftLinkAct').offset().top);
			var m = t - h + 16;
			if (m > 0) {
				$('.leftLinkBtn').css('margin-top', m+'px');
				$('.leftLinkBtn').addClass('leftLinkBtnShow');
			}
		}
	}

	$('.formbox').each(function(){
		if ($('textarea', this).length > 0) {
			if (!$('textarea', this).hasClass('input')) {
				$(this).addClass('formbox_editor');
			}
		}
	});
}

$(document).ready(function(){
	body();

	$('body').on('click', '.imgDel', function(){
		if (confirm('Вы действительно хотите удалить?')) {
			var id = $(this).attr('data-id');
			$('#imgDelete'+id).prop('checked', true);
			$('#imgItem'+id).hide();
		}
	});

	$('.fileBox input[type=file]').change(function(){
		var val = $(this).val();
		val = val.replace("fakepath", "...");
		var fileBox = $(this).parent('.fileBox');
		var file = fileBox.parent('.file');
		$('.fileName', file).html(val);
	});

	$('.imgsBox input[type=file]').change(function(){
		var val = $(this).val();
		val = val.replace("fakepath", "...");
		var imgsBox = $(this).parent('.imgsBox');
		$('.imgsFilename', imgsBox).html(val);
	});

	if ($('.list').css('display') == 'block') {
		if ($('.list').html().trim() == '<div class=\"listClose\"></div>') $('.list').hide();
	}

	$('.index_content').addClass('index_content_show');

	$('body').on('click', '.admin_show', function(){
		var id = $(this).attr('data-id');
		var table = $(this).attr('data-table');

		if ($(this).hasClass('admin_show_act')) {
			show = 0;
			$(this).removeClass('admin_show_act');
		}
		else {
			show = 1;
			$(this).addClass('admin_show_act');
		}

		$.ajax({
			url: '/admin/admin_ajax.php',
			type: 'POST',
			data: {
				'admin_show' : '1'
				, 'id' : id
				, 'table' : table
				, 'show' : show
			},
			success: function(html){

			}
		});
	});

	$('body').on('click', '.pageView', function(){
		var id = $(this).attr('data-id');
		var table = $(this).attr('data-table');

		if ($(this).hasClass('pageViewAct')) {
			show = 0;
			$(this).removeClass('pageViewAct');
		}
		else {
			show = 1;
			$(this).addClass('pageViewAct');
		}

		$.ajax({
			url: '/admin/admin_ajax.php',
			type: 'POST',
			data: {
				'admin_show' : '1'
				, 'id' : id
				, 'table' : table
				, 'show' : show
			},
			success: function(html){

			}
		});
	});

	$('body').on('click', '.listClose', function(){
		$('.list').fadeOut(300);
		$('.leftLink').removeClass('leftLinkAct');
	});

	if ($('.list h1').css('display') == 'block') {
		if ($('.list h1').html() == '') {
			var h1 = $('.leftLinkAct a').html();
			$('.list h1').html(h1);
		}
	}
	else {
		if ($('.leftLinkAct a').css('display')) {
			var h1 = $('.leftLinkAct a').html();
			$('.list').prepend('<h1>'+h1+'</h1>');
		}
	}

	$('body').on('click', '.tab', function(){
		var id = $(this).attr('data-id');

		$('.tab').removeClass('tabAct');
		$(this).addClass('tabAct');

		$('.tabs').hide();
		$('.tabs'+id).fadeIn(300);
	});

	$('body').on('click', '.radio-item', function(){
		$('.radio-item').removeClass('radio-item-act');
		$('.type').hide();
		var val = $('input', this).val();
		if ($('input', this).prop('checked')) {
			$('input', this).prop('checked', false);
			$(this).removeClass('radio-item-act');
		}
		else {
			$('input', this).prop('checked', true);
			$(this).addClass('radio-item-act');
			$('.type'+val).fadeIn(300);
		}
	});

	$('body').on('click', '.button-change', function(){
		if ($(this).css('display') != 'none') {
			$('.radio-item').addClass('radio-item-show');
			$(this).hide();
		}
	});

	$('body').on('change', '.inputRate', function(){
		var table = $(this).attr('data-table');
		var id = $(this).attr('data-id');
		var rate = $(this).val();
		$.ajax({
			url: '/admin/admin_ajax.php',
			type: 'POST',
			data: {
				'admin_rate' : '1'
				, 'table' : table
				, 'id' : id
				, 'rate' : rate
			},
			success: function(html){

			}
		});
	});

});

$(window).resize(function(){
	body();
	compact();
});
function anime(){
	$('.anime').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated fadeIn',
		offset: 100
	});
	$('.anime2').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated bounceInLeft',
		offset: 100
	});
	$('.anime3').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated bounceInUp',
		offset: 100
	});
	$('.anime4').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated fadeInDown',
		offset: 100
	});
	$('.anime5').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated lightSpeedIn',
		offset: 100
	});
	$('.anime6').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated flipInX',
		offset: 100
	});
	$('.anime7').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated bounceInRight',
		offset: 100
	});
	$('.anime8').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated zoomIn',
		offset: 100
	});
	$('.anime9').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated jackInTheBox',
		offset: 100
	});
	$('.anime10').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated zoomInRight',
		offset: 100
	});
	$('.anime11').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated rotateInDownLeft',
		offset: 100
	});
	$('.anime12').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated fadeInLeft',
		offset: 100
	});
	$('.anime13').addClass("hidden").viewportChecker({
		classToAdd: 'visible animated fadeInDown',
		offset: 100
	});
	$('.anime14').addClass("hidden").viewportChecker({
		classToAdd: 'fadeScale',
		offset: 100
	});
}


$('body').on('click', '.checkText', function(){
	var check = $(this).parent('.check');
	if ($('.checkbox', check).prop('checked')) {
		$('.checkbox', check).prop('checked', false);
	}
	else {
		$('.checkbox', check).prop('checked', true);
	}
});

$('body').on('change', '.region select', function(){
	var id = $(this).val();
	$.ajax({
		url: '/admin/admin_ajax.php',
		type: 'POST',
		data: {
			'region_change': id
		},
		success: function(html){
			if (html != '') $('.city').html(html);
		}
	});
});

$('body').on('change', '.city-all input', function(){
	if ($(this).prop('checked') == false) {
		$('.city input').prop('checked', false);
	}
	else {
		$('.city input').prop('checked', true);
	}
});

$('body').on('click', '.sends-status', function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	var text = 'Вы уверены что хотите перенести заявку в новые?';
	if (status == 1) text = 'Вы уверены что хотите перенести заявку в архив?';
	if (confirm(text)) {
		$.ajax({
			url: '/admin/admin_ajax.php',
			type: 'POST',
			data: {
				'sends_status': id
				, 'status': status
			},
			success: function(html){
				top.location.reload();
			}
		});
	}
});

$('body').on('click', '.support-status', function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	var text = 'Вы уверены что хотите перенести заявку в новые?';
	if (status == 1) text = 'Вы уверены что хотите перенести заявку в архив?';
	if (confirm(text)) {
		$.ajax({
			url: '/admin/admin_ajax.php',
			type: 'POST',
			data: {
				'support_status': id
				, 'status': status
			},
			success: function(html){
				top.location.reload();
			}
		});
	}
});

$('body').on('click', '.catalog-sbm', function(e){
	var cat = $('.cat select').val();
	$('.cat select').removeClass('input-red');
	if (cat == 0) {
		alert('Необходимо выбрать категорию');
		$('.cat select').addClass('input-red');
		e.preventDefault();
		return false;
	}
});


$(document).ready(function(){
	$(function() {
		$('.sortable').sortable({
			deactivate: function( event, ui ) {
				filter = Array();
				i = 0;
				$('.filter').each(function(){
					filter[i] = $(this).attr('data-id');
					i++;
				});
				var table = $('.sortable').attr('data-table');
				var nav = $('.sortable').attr('data-nav');
				$.ajax({
					url: '/admin/admin_ajax.php',
					type: 'POST',
					data: {
						'sort_filter' : 1
						, 'filter' : filter
						, 'table' : table
						, 'nav' : nav
					}
				});
			}
		});
		$('.sortable-gallbox').each(function(){
			var gallbox = $(this);
			$(this).sortable({
				deactivate: function( event, ui ) {
					filter = Array();
					i = 0;
					$('.filter', gallbox).each(function(){
						filter[i] = $(this).attr('data-id');
						i++;
					});

					$.ajax({
						url: '/admin/admin_ajax.php',
						type: 'POST',
						data: {
							'sort_filter' : 1
							, 'filter' : filter
							, 'table' : 'gallery'
						}
					});
				}
			});
			gallbox.disableSelection();
		});
	});
});


$('.radio-type input').change(function(){
	var val = $(this).val();
	var cat = $('.cat select').val();
	$.ajax({
		url: '/admin/admin_ajax.php',
		type: 'POST',
		data: {
			'radio_type' : val
			, 'cat' : cat
		},
		success: function(html){
			if (html != '') {
				$('.cat').html(html);
			}
		}
	});
});

$('body').on('change', '.status-change', function(){
	var id = $(this).val();
	var url = $(this).attr('data-url');
	if (url != '') {
		url = url + id;
		top.location.href = url;
	}
});

if ($('.chosen').length > 0) {
	$('.chosen').chosen({
		no_results_text: "Ничего не найдено...",
		width:'100%',
		search_contains: true
	});
}

/* --- Item add --- */

$('body').on('click', '.items-add', function(e){
	var type = $(this).attr('data-type');
	var ids = $(this).attr('data-ids');
	var parent = $(this).parent();
	$.ajax({
		url: '/admin/admin_ajax.php',
		type: 'POST',
		data: {
			'items_add' : 1
			, 'type' : type
			, 'ids' : ids
		},
		success: function(html){
			$('.items', parent).html(html);
		}
	});
});

$('body').on('change', '.items-input', function(e){
	var id = $(this).attr('data-id');
	var field = $(this).attr('data-field');
	var name = $(this).val();
	$.ajax({
		url: '/admin/admin_ajax.php',
		type: 'POST',
		data: {
			'items_change' : 1
			, 'id' : id
			, 'name' : name
			, 'field' : field
		},
		success: function(html){

		}
	});
});

$('body').on('click', '.items-del', function(e){
	var id = $(this).attr('data-id');
	if (confirm('Вы уверены что хотите удалить запись?')) {
		$.ajax({
			url: '/admin/admin_ajax.php',
			type: 'POST',
			data: {
				'items_del' : 1
				, 'id' : id
			},
			success: function(html){
				$('#item'+id).remove();
			}
		});
	}
});

/* --- // --- */
