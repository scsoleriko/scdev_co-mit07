$(function() {

	/* スムーズスクロール
	******************************************/
  $('a[href^="#"]').click(function() {
    let speed = 600;
    let type = 'swing';
    let href= $(this).attr("href");
    let target = $(href == "#index" ? 'html' : href);
    let position = target.offset().top;
    $('body,html').animate({scrollTop:position}, speed, type);
    return false;
  });

	/* ファーストビュー
	******************************************/
	const fvswiper = new Swiper('.fv-swiper', {
		loop: false,
		autoplay: {
			delay: 2500,
			disableOnInteraction: false,
		},
		effect: 'fade',
	});

	if ( window.matchMedia('(max-width: 768px)').matches ) {
		const foodSwiper = new Swiper(".food-swiper", {
			slidesPerView: "auto",
			centeredSlides: true,
			spaceBetween: 15,
		});
	}

	/* お申込み追従ボタン
	******************************************/
	var formBtn = $('#fixed-form');
	var formBtn_hiddenPoint = $('#form').offset().top - ( $('#form').height() / 2 );

	$(window).on('scroll', function() {
		if ($(this).scrollTop() > formBtn_hiddenPoint) {
			formBtn.fadeOut();
		} else {
			formBtn.fadeIn();
		}
	});


	/* 呉市の魅力
	******************************************/
	$('.appeal-nav li, .appeal-nav2 li').click(function(){
		let area = '#' + $(this).data('area');
		let index = area.slice(-1);
	
		$('.appeal-nav li').removeClass('current');
		$('.appeal-areaWrap').removeClass('current');

		$('.appeal-nav li:nth-child(' + index + ')').addClass('current');
		$(area).addClass('current');
	});

	/* モニターツアー
	******************************************/
	$('#tour .more button').click(function(){
		$('#tour .tour-more').show();
		$('#tour .more').hide();
	});

	$('#tour .close button').click(function(){
		$('#tour .tour-more').hide();
		$('#tour .more').show();
	});

	/* modal
	******************************************/
	$('.modal-close').click(function(){
		$('.modal').modaal('close');
	});


	/* ワークスペース
	******************************************/
	const workspaceSwiperWrap = new Swiper(".workspace-swiper_wrapper", {
		slidesPerView: 'auto',
		spaceBetween: 15,
		loop: true,
		autoplay: {
			delay: 2500,
			disableOnInteraction: false,
		},
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		breakpoints: {
			769: {
				slidesPerView: 'auto',
				spaceBetween: 35,
			},
		},
	});

	var workspaceSwiper = new Swiper('.workspace-swiper', {
		loop: false,
		// autoplay: {
		// 	delay: 2500,
		// 	disableOnInteraction: false,
		// },
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
	});

	$('#workspace .btn-more').modaal({
		type: 'iframe',
		width: 1000,
		custom_class: 'workspace-modal',
	});

});