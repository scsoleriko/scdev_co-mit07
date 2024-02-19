$(function(){

var $window = $(window),
		breakPoint = 768, //ブレイクポイントの設定
		winW = $window.width(), //画面の横幅
		winH = $window.height(), //画面の縦幅
		anchorSpeed = 400, //アンカーリンクのスムーズスクロールのスピード
		resizeTimer = false;


/* [library] object fit
*********************************************/
objectFitImages();

/* change Img
*********************************************/
function changeImgSp(){
	$('.change-img').each(function(){
		$(this).attr("src",$(this).attr("src").replace(/_pc\./, '_sp.'));
	});
}
function changeImgPc(){
	$('.change-img').each(function(){
		$(this).attr("src",$(this).attr("src").replace(/_sp\./, '_pc.'));
	});
}

/* pagetop animation
*********************************************/
$('.pagetop').click(function () {
	$('body,html').animate({
		scrollTop: 0
	}, 500);
	return false;
});

/* スクロール
*********************************************/
$(window).scroll(function (){
	var scroll = $(window).scrollTop();

	/* pagetop show/hidden & facility-list cv fixed btn
	*********************************/
	if (scroll > 500 ){
		$('.pagetop').addClass('is-visible');
	} else {
		$('.pagetop').removeClass('is-visible');
	}

});

/* smooth scroll
*********************************************/
var headerHeight = 0;
// var headerHeight = $('.l-header').outerHeight(); //headerが常時追従の場合はこれをアンコメント
var urlHash = location.hash;

if(urlHash) {
	$('body,html').stop().scrollTop(0);
	setTimeout(function(){
		var target = $(urlHash);
		smoothScroll(target);
	}, 100);
}
$('.anchor').click(function() {
	var href= $(this).attr("href");
	var target = $(href);
	smoothScroll(target);
	return false;
});

function smoothScroll(target) {
	var position = target.offset().top - headerHeight;
	$("html, body").animate({scrollTop:position}, anchorSpeed, "swing");
}

/* SCROLL BLOCK - メニュー等が開いている間はコンテンツがスクロールしないよう制御
*********************************************/
function scrollBlocker(flag){
	if(flag){
		scrollpos = $(window).scrollTop();
		$('.l-body').addClass('is-fixed').css({'top': -scrollpos});
	} else {
		$('.l-body').removeClass('is-fixed').removeAttr('style');
		window.scrollTo( 0 , scrollpos );
	}
}
// scrollBlocker(true); //スクロールブロック有効
// scrollBlocker(false); //スクロールブロック無効


/* 事例紹介top
*********************************************/

if ($("#case-study .swiper-container").length) {

	var opt = {
	  autoplay: {
	    delay: 2000,
	  },
    // spaceBetween: 12,
    centeredSlides: true,
		slidesPerView: 'auto',
		speed: 500,
		loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
		// navigation: {
		// 	nextEl: '.banner-swiper-button-next',
		// 	prevEl: '.banner-swiper-button-prev',
		// }
	};

	console.log(opt)

	// var bannerSwiper = new Swiper('#case-study .swiper-container', opt);
}

/* リアルxゆらぎxプロセスのスライド切り替え
*********************************************/
var slider01nav_swiper = new Swiper('.slider01-nav.swiper-container', {
	slidesPerView: 3,
	allowTouchMove: false,
	speed: 500,
	autoplay: {
		delay: 4000,
		disableOnInteraction: false,
	},
});
var slider01_swiper = new Swiper('.slider01__wrapper.swiper-container', {
	slidesPerView: 1,
	loop: true,
	speed: 500,
	autoplay: {
		delay: 10000,
		disableOnInteraction: false,
	},
	thumbs: {
		swiper: slider01nav_swiper,
	},
});

/* 専門家インタビュー スライダー
*********************************************/
var slider02_swiper = new Swiper('.slider02.swiper-container', {
	slidesPerView: 'auto',
	loop: false,
	speed: 500,
});

/* ABOUT ループスライダー
*********************************************/
var slider03_swiper = new Swiper('.slider03.swiper-container', {
	allowTouchMove: false,
  loop: true,
  slidesPerView: 'auto',
  speed: 12000,
  autoplay: {
    delay: 0,
  },
});

/* single 導入部分スライダー
*********************************************/
var slider04_swiper = new Swiper('.slider04.swiper-container', {
	allowTouchMove: false,
	loop: true,
  slidesPerView: 'auto',
  speed: 2000,
  autoplay: {
    delay: 3000,
  },
  effect: "fade",
});

/* single　ギャラリースライダー（連動）
*********************************************/
var gallerynav_swiper = new Swiper('.gallery-nav.swiper-container', {
	slidesPerView: 'auto',
	allowTouchMove: false,
	speed: 500,
	autoplay: {
		delay: 4000,
		disableOnInteraction: false,
	},
});

var bar = document.querySelector('.gallery-progress__bar');
var barDuration = 5000;
var gallerymain_swiper = new Swiper('.gallery-main.swiper-container', {
	slidesPerView: 1,
	loop: true,
	speed: 500,
	effect: "fade",
	autoplay: {
		delay: 5000,
		disableOnInteraction: false,
	},
	thumbs: {
		swiper: gallerynav_swiper,
	},
	on: {
	//スライド（次または前）へのアニメーションの開始後にイベント発生
		slideChangeTransitionStart: function (result) {
			bar.style.transitionDuration = '0s',
			bar.style.transform = 'scaleX(0)'
		},
		//スライド（次または前）へのアニメーションの開始後にイベント発生
		slideChangeTransitionEnd: function (result) {
			bar.style.transitionDuration = barDuration + 'ms',
			bar.style.transform = 'scaleX(1)'
		},
	}
});



/* sp menu
*********************************************/
$('.menu-btn').click(function() {
	$('.l-body').toggleClass('is-menu-open');
	if($('.l-body').hasClass('is-fixed')) {
		scrollBlocker(false);
	} else {
		scrollBlocker(true);
	}
	return false;
});
//リンク押したら解除
$('.navi a').click(function() {
	$('.l-body').removeClass('is-menu-open');
	scrollBlocker(false);
});



/* モーダル
*********************************************/
$('.js-modal-trg').click(function(){
//モーダル開いている間はスクロールしない
	scrollpos = $(window).scrollTop();
	$('.l-body').addClass('is-fixed').css({'top': -scrollpos});
//モーダル生成
	var targetModal = $(this).attr('href');
	$(targetModal).addClass('is-visible');
	$(targetModal).after('<span class="modal-bg"></span>');
	$('.modal-bg').hide().fadeIn(300);
	return false;
});

$(document).on("click", ".modal-bg,.modal__close", function(){
//モーダル閉じたらスクロール解除
	$('.l-body').removeClass('is-fixed').removeAttr('style');
	window.scrollTo( 0 , scrollpos );
//モーダル非表示
	$('.modal').removeClass('is-visible');
	$('.modal-bg').fadeOut(300).queue(function() {
		this.remove();
	});
	return false;
});




/********************************************
 [PC ONLY]
*********************************************/
function pcSizeOnly(){

	/* 画像PC/SP切り替え
	*******************************************/
	changeImgPc();

	/* tile
	*******************************************/
	$('.point-fig__sub-heading').tile();

}

/********************************************
 [SP ONLY]
*********************************************/
function spSizeOnly(){

	/* 画像PC/SP切り替え
	*******************************************/
	changeImgSp();

	/* tile
	*******************************************/
	$('.point-fig__sub-heading').removeAttr('style');

}

/********************************************
 [PC/SP切り替え] 以下編集不可
*********************************************/
function descriminateBp(){
	winW = $window.width();
	if(winW <= breakPoint){
		spSizeOnly();
	}else if(winW > breakPoint){
		pcSizeOnly();
	}
}
descriminateBp();
$window.resize(function() {
	if(winW > $window.width() || winW < $window.width()){
		if (resizeTimer !== false) {
			clearTimeout(resizeTimer);
		}
		resizeTimer = setTimeout(descriminateBp, 200);
	}
});

});