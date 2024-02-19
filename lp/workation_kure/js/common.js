$(function() {
	/*
	var topBtn = $('.pagetop');
	var topBtn_visiblePoint = $('header').height() + $('.breadcrumb').height();

	$(window).on('scroll', function() {
		if ($(this).scrollTop() > topBtn_visiblePoint) {
			topBtn.fadeIn();
		} else {
			topBtn.fadeOut();
		}
	});
	*/

	$('.sp-menu-btn').click(function() {
		$(this).toggleClass('is-opend');
		$('.navi').fadeToggle();
		$('body').toggleClass('is-fixed');
	});

	$('.navi__main__item a').click(function() {
		$('.sp-menu-btn').removeClass('is-opend');
		$('.navi').fadeOut();
		$('body').removeClass('is-fixed');
	});
});

