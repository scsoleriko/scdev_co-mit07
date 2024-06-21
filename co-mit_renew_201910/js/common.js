!function(){  // limit scope
	$(function(){
		var $window = $(window),
		breakPoint = 768, //ブレイクポイントの設定
		wid = $window.width(),
		height = $window.height(),
		resizeTimer = false,
		clickEvent = ('ontouchend' in window)? 'touchend' : 'click';

//////////////////////////////////////////////
//
//   function - parts
//
//////////////////////////////////////////////

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

//////////////////////////////////////////////
//
//   Common - PC / SP
//
//////////////////////////////////////////////

/* smooth scroll
*********************************************/
$('.anchor').click(function(){
	var speed = 400;
	var href= $(this).attr("href");
	var target = $(href == "#" || href == "" ? 'html' : href);
	var position = target.offset().top;
	$("html, body").animate({scrollTop:position}, speed, "swing");
	return false;
});

/* object fit
*********************************************/
objectFitImages();

/* DON'T SCROLL
*********************************************/
// spメニューorコンテンツメニューが開いている間はスクロールしない
var scrollBlockerFlag;
function scrollBlocker(flag){
	if(flag){
		scrollpos = $(window).scrollTop();
		$('.l-body').addClass('is-fixed').css({'top': -scrollpos});
		scrollBlockerFlag = true;
	} else {
		$('.l-body').removeClass('is-fixed').removeAttr('style');
		window.scrollTo( 0 , scrollpos );
		scrollBlockerFlag = false;
	}
}

/* pagetop animation
*********************************************/
var topBtn = $('.pagetop');
topBtn.click(function () {
	$('body,html').animate({
		scrollTop: 0
	}, 500);
	return false;
});
var jumpToBtn = $('.jumpToBtn');
jumpToBtn.click(function () {
	var href = $(this).attr("href");
	$('body,html').animate({
		scrollTop: $(href).offset().top - $(".detail-tabs").height()
	}, 500);
	return false;
});

/* スクロール
*********************************************/
$(window).scroll(function (){
	var scroll = $(window).scrollTop();

	/* pagetop show/hidden & facility-list cv fixed btn
	*********************************/
	if (scroll > height ){
		topBtn.fadeIn('fast');
		$('.cv-facility').fadeIn('fast');
	} else {
		topBtn.fadeOut('fast');
		$('.cv-facility').fadeOut('fast');
	}

	/* top smartbar
	*********************************/
	if(wid > breakPoint) {
		if (scroll > height ){ //ナビバーIN
			$('.smartbar').fadeIn();
		} else { //ナビバーOUT
			$('.smartbar').fadeOut('fast');
			if($('.navi').hasClass('is-side-opend')) {
				$('.navi').removeClass('is-side-opend');
				$('.sp-menu-btn').removeClass('is-opend');
			}
			// if (scroll > 200 ){ //ナビIN
			// 	$('.navi').addClass('navi--pc-side');
			// } else { //ナビOUT
			// 	$('.navi').removeClass('navi--pc-side');
			// }
		}
	}

	/* top chat
	*********************************/
	$chatHeight = $('.chat').innerHeight();
	if (scroll > $chatHeight - height ){
		$('.chat__button').addClass('is-fixed');
	} else {
		$('.chat__button').removeClass('is-fixed');
	}

});

/* common favorite btn
*********************************/
  //※パターン１
  /*$(".navi__favorite__btn a,.navi__favorite__detail,.navi__favorite__detail__inner").hover(function() {
    $(".navi__favorite__detail__inner").css("display","block");
  }, function() {
    $(".navi__favorite__detail__inner").css("display","none");
  });*/

/* facility detail sticky
*********************************************/
var $tabLink = $('.tabLink');
var $tabLinksURL = [];
$tabLink.each(function(){
	$tabLinksURL.push( $(this).attr('href') );
});

if($('div').hasClass('sticky')) {
	$stickyPos = $('.sticky').offset().top;
	$stickyHeight = $('.sticky').innerHeight();
	var $detailHeader = $('nav.detail-tabs');
	var adjustHeight = $detailHeader.find('ul').height();
	var userAgent = window.navigator.userAgent.toLowerCase();
	var $tab_outer = $('.detail-tabs-outer');


		//default
		$tab_outer.css('position', 'absolute');
		$('.sticky').css({
			'padding-top': adjustHeight,
			'position': 'relative'
		});

		//ロード・スクロール
		$(window).on('load scroll', function (){
			var scroll = $(window).scrollTop();
			if (scroll >= $stickyPos && scroll <= $stickyPos + $stickyHeight ){
				$tab_outer.css({
					'position': 'fixed',
					'top': '0',
					'bottom': 'auto',
				});
				$tab_outer.addClass('fixed');
				$tabLink.each(function(number){
					$(this).attr('href', $tabLinksURL[number]+"#tab");
				});
			}
			// else if(scroll > $stickyPos + $stickyHeight) {
			//   $tab_outer.css({
			//     'position': 'absolute',
			//     'top': 'auto',
			//     'bottom': '0',
			//   });
			//   $tab_outer.removeClass('fixed');
			// }
			else if(scroll < $stickyPos) {
				$tab_outer.css({
					'position': 'absolute',
					'top': '0',
					'bottom': 'auto',
				});
				$tab_outer.removeClass('fixed');
				$tabLink.each(function(number){
					$(this).attr('href', $tabLinksURL[number]);
				});
			}
		});
}

/* sp- menu
*********************************************/
$('.sp-menu-btn').click(function(){
	$(this).toggleClass('is-opend');
	if(wid <= breakPoint) { //sp
		$('.navi--pc-side').fadeToggle();
		if($('.l-body').hasClass('is-fixed')) {
			scrollBlocker(false);
		} else {
			scrollBlocker(true);
		}
	} else { //pc
		$('.navi').toggleClass('is-side-opend');
	}
	return false;
});

/* side-btn
*********************************************/
var sideBtn01 = $('.js-fixed-btn-01'),
		sideBtn02 = $('.js-fixed-btn-02');

if (sideBtn01.length > 0) {
	var sideBtnEnd;
	var sideBtnShow = function(){
		if ( !($(window).scrollTop() < sideBtnEnd) ) {
			sideBtn01.removeClass('is-show');
		} else {
			sideBtn01.addClass('is-show');
		}
	}
	$(window).on('load resize', function(){
		sideBtnEnd = $('.js-fixed-btn-01__end').offset().top - 300;
	});
	$(window).on('load scroll', function(){
		sideBtnShow();
	});
}

if (sideBtn02.length > 0) {
	var sideBtnShow2 = function(){
		if ( !($(window).scrollTop() < 200) ) {
			sideBtn02.addClass('is-show');
		} else {
			sideBtn02.removeClass('is-show');
		}
	}
	$(window).on('load scroll', function(){
		sideBtnShow2();
	});
}

/* facility-list search accordion
*********************************************/
$('.search-area__head').click(function(){
	$(this).next('.search-area__content').slideToggle('fast');
	$(this).toggleClass('is-opend');
	return false;
});

$('.search-box__detail__head a').click(function(){
	var target = $(this).attr("href");
	$(target).slideToggle('fast');
	$(this).parent('.search-box__detail__head').toggleClass('is-opend');
	return false;
});


/* facility-list refine sp
*********************************************/
$('.sp-refine-btn').click(function(){
	$('.l-search').slideToggle('fast');
	if($('.l-body').hasClass('is-fixed')) {
		scrollBlocker(false);
		$(this).html('絞り込み検索はこちら');
	} else {
		scrollBlocker(true);
		$(this).html('絞り込み検索を閉じる');
	}
	return false;
});

/* facility-list cv fixed btn
*********************************************/
if($('div').hasClass('cv-facility')) {
	$cvHeight = $('.cv-facility').innerHeight();
	$('.l-body').css('padding-bottom', $cvHeight);
}

/* swiper
*********************************************/
// TOP
$(window).on('load',function(){
	if ($(".swiper-container--banner").length) {

		var opt = {
		  autoplay: {
		    delay: 5000,
		  },
	    spaceBetween: 12,
	    centeredSlides: true,
			slidesPerView: 'auto',
			loop: true,
	    pagination: {
	      el: ".swiper-pagination",
	      clickable: true,
	    },
			navigation: {
				nextEl: '.banner-swiper-button-next',
				prevEl: '.banner-swiper-button-prev',
			}
		};

		var bannerSwiper = new Swiper('.swiper-container--banner', opt);
	}


	var swiper = new Swiper('.swiper-container--facility', {
		slidesPerView: 'auto',
		//spaceBetween: 19,
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		breakpoints: {
			768: {
				//spaceBetween: 40,
			},
		},
		on : {
			touchStart: function(){
				$('.swiper-button-next').fadeIn(500);
			},
			reachEnd: function(){
				$('.swiper-button-next').fadeOut(500);
			},
		}
	});
	var swiper = new Swiper('.swiper-container--facility-02', {
		slidesPerView: 'auto',
		//spaceBetween: 19,
		navigation: {
			nextEl: '.swiper-button-next-02',
			prevEl: '.swiper-button-prev-02',
		},
		breakpoints: {
			768: {
				//spaceBetween: 40,
			},
		},
		on : {
			touchStart: function(){
				$('.swiper-button-next-02').fadeIn(500);
			},
			reachEnd: function(){
				$('.swiper-button-next-02').fadeOut(500);
			},
		}
	});
	var swiper = new Swiper('.swiper-container--facility-03', {
		slidesPerView: 'auto',
		//spaceBetween: 19,
		navigation: {
			nextEl: '.swiper-button-next-03',
			prevEl: '.swiper-button-prev-03',
		},
		breakpoints: {
			768: {
				//spaceBetween: 40,
			},
		},
		on : {
			touchStart: function(){
				$('.swiper-button-next-03').fadeIn(500);
			},
			reachEnd: function(){
				$('.swiper-button-next-03').fadeOut(500);
			},
		}
	});


	// TOP
	var swiper = new Swiper('#slider-blog', {
		slidesPerView: 'auto',
		navigation: {
			nextEl: '#slider-blog-next',
		},
		on : {
			touchStart: function(){
				$('#slider-blog-next').fadeIn(500);
			},
			reachEnd: function(){
				$('#slider-blog-next').fadeOut(500);
			},
		}
	});

	var swiper = new Swiper('#slider-special', {
		slidesPerView: 'auto',
		navigation: {
			nextEl: '#slider-special-next',
		},
		on : {
			touchStart: function(){
				$('#slider-special-next').fadeIn(500);
			},
			reachEnd: function(){
				$('#slider-special-next').fadeOut(500);
			},
		}
	});

	if ($(".swiper-container--banner").length) {
    var swiper = new Swiper('#slider-special', {
      slidesPerView: 'auto',
      navigation: {
        nextEl: '#slider-special-next',
      },
      on : {
        touchStart: function(){
          $('#slider-special-next').fadeIn(500);
        },
        reachEnd: function(){
          $('#slider-special-next').fadeOut(500);
        },
      }
    });
  }
	
	if ($("#slider-search-type").length) {
		var swiper = new Swiper('#slider-search-type', {
			slidesPerView: 'auto',
			spaceBetween: 20,
		});  
	}
  
	var h = $('.swiper-slide__height').height();
	var h2 = $('.swiper-slide__height02').height();
	if(h !== undefined && h !== '') {
		$('.swiper-reccomend .swiper-button-next').css('height', h + 'px');
	}
	if(h2 !== undefined && h2 !== '') {
		$('.swiper-reccomend02 .swiper-button-next').css('height', h2 + 'px');
	}

});
// 記事詳細
var swiper = new Swiper('.swiper-container--column', {
	slidesPerView: 1,
	loop: true,
	//spaceBetween: 19,
	navigation: {
		nextEl: '.swiper-button-next-column',
		prevEl: '.swiper-button-prev-column',
	},
	breakpoints: {
		769: {
			slidesPerView: 3,
			spaceBetween: 35
		}
	}
});
// この施設を見ている人はこの施設も見ています
var recommend01 = new Swiper('#recommend-facility.swiper-container--facility_post', {
	slidesPerView: 1,
	loop: true,
	//spaceBetween: 19,
	navigation: {
		nextEl: '.recommend-facility-next',
		prevEl: '.recommend-facility-prev',
	},
	breakpoints: {
		769: {
			slidesPerView: 4,
			spaceBetween: 35
		}
	}
});
//PICK UP 人事、総務、研修担当者必見のコンテンツ
var recommend02 = new Swiper('#recommend-jinji.swiper-container--facility_post', {
	slidesPerView: 1,
	loop: true,
	//spaceBetween: 19,
	navigation: {
		nextEl: '.recommend-jinji-next',
		prevEl: '.recommend-jinji-prev',
	},
	breakpoints: {
		769: {
			slidesPerView: 4,
			spaceBetween: 35
		}
	}
});
//ランキング
var recommend02 = new Swiper('#ranking-facility.swiper-container--facility_post', {
	slidesPerView: 1,
	loop: true,
	//spaceBetween: 19,
	navigation: {
		nextEl: '.ranking-facility-next',
		prevEl: '.ranking-facility-prev',
	},
	breakpoints: {
		769: {
			slidesPerView: 4,
			spaceBetween: 35
		}
	}
});

$(window).resize(function() {
	//リサイズされたときの処理
	var h = $('.swiper-slide__height').height();
	var h2 = $('.swiper-slide__height02').height();
	if(h !== undefined && h !== '') {
		$('.swiper-reccomend .swiper-button-next').css('height', h + 'px');
	}
	if(h2 !== undefined && h2 !== '') {
		$('.swiper-reccomend02 .swiper-button-next').css('height', h2 + 'px');
	}
});

// FACILITY
var galleryThumbs = null;
if ($(".facility-gallery__thumbs").length) {
	galleryThumbs = new Swiper('.facility-gallery__thumbs', {
		spaceBetween: 10,
		slidesPerView: 'auto',
		// loop: true,
		// freeMode: true,
		watchSlidesVisibility: true,
		watchSlidesProgress: true,
		// centeredSlides: true,
		breakpoints: {
			breakPoint: {
				spaceBetween: 20,
				slidesPerView: 4,
			},
		},
	});
}

//1枚の時の処理
var sliderImg = $('.facility-gallery__main .swiper-slide').length;
if(sliderImg == 1){
  $('.facility-gallery__main .swiper-slide').clone(true).insertAfter('.facility-gallery__main .swiper-slide');
}

var facilityGallery__main_option = {
	spaceBetween: 0,
	slidesPerView: 1,
  loop: true,
  loopAdditionalSlides: 2
}
if (galleryThumbs) {
	facilityGallery__main_option["thumbs"] = {
		swiper: galleryThumbs
	};
} else {
	facilityGallery__main_option["navigation"] = {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev'
	}
}

var galleryTop = new Swiper('.facility-gallery__main', facilityGallery__main_option);

// コラムテンプレート
var premiumThumbs = null;
if ($(".premium-gallery__thumbs").length) {
	premiumThumbs = new Swiper('.premium-gallery__thumbs', {
		spaceBetween: 10,
		slidesPerView: 'auto',
		// loop: true,
		// freeMode: true,
		watchSlidesVisibility: true,
		watchSlidesProgress: true,
		// centeredSlides: true,
		breakpoints: {
			breakPoint: {
				spaceBetween: 20,
				slidesPerView: 4,
			},
		},
	});
}

//1枚の時の処理
var sliderImg = $('.premium-gallery__main .swiper-slide').length;
if(sliderImg == 1){
  $('.premium-gallery__main .swiper-slide').clone(true).insertAfter('.premium-gallery__main .swiper-slide');
}

var facilityGallery__main_option = {
	spaceBetween: 0,
	slidesPerView: 1,
  loop: true,
  loopAdditionalSlides: 2,
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},
}
if (premiumThumbs) {
	facilityGallery__main_option["thumbs"] = {
		swiper: premiumThumbs
	};
}

var galleryTop = new Swiper('.premium-gallery__main', facilityGallery__main_option);
    
    
    
if ($("#facility_points_slider").length) {
	$(window).on("load", function () {
		new Swiper('#facility_points_slider.swiper-container', {
	    spaceBetween: 0,
	    slidesPerView: 1,
	    loop: true,
	    pagination: {
	      el: '.swiper-pagination',
	      clickable: true
	    },
	    autoplay: {
	        delay: 3000,
			},
	  });
	})
}
if ($(".home-fv__slider").length) {
  
  const $listThumb = $('.listThumb');
  var isMobile = $(window).width() < 768;
  if(isMobile){
    $listThumb.bxSlider({
      auto: true,
      moveSlides: 1,
      infiniteLoop: true,
      slideMargin: 15,
      minSlides: 2,
      maxSlides: 2,
      controls: false,
      pager: false,
      responsive: true 
    });
  }else{
    slider = $('.mainImage').bxSlider({
      auto: true,
      mode: 'fade',
      pagerCustom: '.listThumb',
      controls: false,
      speed: 0,
      touchEnabled: false
    });
    $listThumb.bxSlider({
      auto: true,
      moveSlides: 1,
      infiniteLoop: true,
      slideMargin: 15,
      minSlides: 4,
      maxSlides: 4,
      slideWidth: 167,
      pager: false,
      prevText: '',
      nextText: '',
      touchEnabled: false
    });
    $('.listThumb a').hover(function () {
        slider.goToSlide($(this).attr('data-slide-index'));
      });
  }
  const fvSlideThumb = new Swiper('.home-fv__mainslider-thumb', {
    spaceBetween: 10,
    slidesPerView: 4,
/*    autoplay: { // 自動再生させる
      delay: 5000, // 次のスライドに切り替わるまでの時間（ミリ秒）
    },*/
    navigation: {
      prevEl: '.fv-button-prev',
      nextEl: '.fv-button-next',
    },
    loop: true,
    centeredSlides: true,
    loopAdditionalSlides: 1,
  });  
  
  const fvSlide = new Swiper('.home-fv__mainslider', {
    slidesPerView: 2,
    loop: true,
    spaceBetween: 10,
    autoplay: { // 自動再生させる
      delay: 5000, // 次のスライドに切り替わるまでの時間（ミリ秒）
    },
    thumbs: {
      swiper: fvSlideThumb // サムネイルのスライダーのインスタンス名
    },
    breakpoints: {
      769: {
        slidesPerView: 1,
        spaceBetween: 0,
				autoplay: false
      }
    }
  });  
  $('.home-fv__mainslider-thumb .swiper-slide a').hover(function () {
    fvSlide.slideTo($(this).attr('data-slide-index'));
  });
  $('.home-fv__mainslider-thumb .swiper-slide a').click(function () {
    if($(this).attr('href') == ''){
      return false;
    }
  });
}
if ($(".service-area-row").length) {
	// サムネイル
	const sliderThumbnail = new Swiper(".slider-thumbnail", {
		slidesPerView: 5, // サムネイルの枚数
		spaceBetween: 10,
	});
	// スライダー
	const slider = new Swiper(".slider", {
		loop: true,
		slidesPerView: 1,
		// 前後の矢印
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		thumbs: {
			swiper: sliderThumbnail,
		},
	});
}
var facilitySliderInit = function(){

  $('.facility-list-1').each(function(){
    if ( $(this).parents('.facility-list').css('display') != 'none' &&
         !$(this).hasClass('sliderInit')
    ) {
      $(this).addClass('sliderInit is-beforeInit');
    }
  });

  var facilityListAll = new Swiper('.sliderInit.is-beforeInit .facility_listimageSlide', {
    spaceBetween: 0,
    slidesPerView: 1,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    }
  });

  $('.sliderInit.is-beforeInit').each(function(){
    $(this).removeClass('is-beforeInit');
  });
}

facilitySliderInit();

$('a#btn_list_more').click(function() {
  setTimeout(function(){
    facilitySliderInit();
  },1500); //ロード処理後に実行
});

/*$('.facility_listimageSlide').hover(function() {
    $(this).find('.swiper-button-prev,.swiper-button-next').stop().fadeIn(500);
}, function() {
    $(this).find('.swiper-button-prev,.swiper-button-next').stop().fadeOut(500);
});*/

/* [CLASSIC] タブの高さなど
*********************************************/
/*if($('nav.detail-tabs').length){
	var $detailHeader = $('nav.detail-tabs');
	var windowW = window.innerWidth;
	if(windowW > 768) {} else {
		if(! $detailHeader.find('li:eq(0)').hasClass('is_active') ){
			var position = $('.sticky').offset().top;
			$('body,html').scrollTop(position);
		}
	}

	function adjustDetailHeaderScroll() {
		$detailHeader.find('div.inner').css('margin-left',$('div.inner:first').outerWidth() / -2 );
		var adjustHeight = $detailHeader.find('ul').height();
		$detailHeader.height(adjustHeight);
		$detailHeader.parent('div.detail-tabs-outer').height(adjustHeight);
	}
	adjustDetailHeaderScroll();

	$(window).on('load resize', function(){
		adjustDetailHeaderScroll();
	});
}*/


//////////////////////////////////////////////
//
//   Only Pc Size Processing
//
function pcSizeOnly(){
//////////////////////////////////////////////
changeImgPc();


/* facility-list refine sp（解除）
*********************************************/
$('.sp-refine-btn').html('絞り込み検索はこちら');
$('.l-search').removeAttr('style');
$('.l-body').removeClass('is-fixed');

/* sp- menu（解除）
*********************************************/
$('.navi').removeAttr('style');
$('.sp-menu-btn').removeClass('is-opend');
$('.l-body').removeClass('is-fixed');


/*
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
PCの時のみ実行するものの追加スペース
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
*/


//////////////////////////////////////////////
}
//   Only Sp Size Processing
//
function spSizeOnly(){
//////////////////////////////////////////////
changeImgSp();

/*
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
SPの時のみ実行するものの追加スペース
■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
*/
    //アコーディオンをクリックした時の動作
		$('.f_accordion__title').on('click', function() {
			var findElm = $(this).next(".f_accordion__content");
			$(findElm).slideToggle();//アコーディオンの上下動作
			if($(this).hasClass('is-open')){
				$(this).removeClass('is-open');
			}else{//それ以外は
				$(this).addClass('is-open');
			}
		});

//////////////////////////////////////////////
}
//   Break Point & Window Resize
//
//////////////////////////////////////////////
		function descriminateBp(){
			wid = $window.width();
			if(wid <= breakPoint){
				spSizeOnly();
			}else if(wid > breakPoint){
				pcSizeOnly();
			}
		}
		descriminateBp();
		$window.resize(function() {
			if(wid > $window.width() || wid < $window.width()){
				if (resizeTimer !== false) {
					clearTimeout(resizeTimer);
				}
				resizeTimer = setTimeout(descriminateBp, 200);
			}
		});
	});

		var facilityListAdjust = function(i) {
			var windowW = window.innerWidth;
			if(windowW > 768) {
				//Selections height調整
				var facilities = $('ul.facility-list').eq(i).children('li').length;
				var facilities_line = Math.ceil(facilities / 2);
				for (n = 0; n < facilities_line; n++) {
					var targetHH = 0;
					var targetTagHH = 0;
					var targetDataHH = 0;
					for (nn = 0; nn < 2; nn++) {
						var target_facilities = (2 * n) + nn;
						//alert(target_selections);
						var headerHH = $('ul.facility-list').eq(i).find('article.facility-content').children('a').eq(target_facilities).height() + 25;
						if(headerHH > targetHH){
							var targetHH = headerHH;
						}
						var tagHH = $('ul.facility-list').eq(i).find('article.facility-content').children('div.tag-list').eq(target_facilities).height();
						if(tagHH > targetTagHH){
							var targetTagHH = tagHH;
						}
						var dataHH = $('ul.facility-list').eq(i).find('article.facility-content').children('ul.facility-data-list').eq(target_facilities).height();
						if(dataHH > targetDataHH){
							var targetDataHH = dataHH;
						}

					}
					var targetHH = targetHH + 'px';
					var targetTagHH = targetTagHH + 'px';
					var targetDataHH = targetDataHH + 'px';
					for (nnn = 0; nnn < 2; nnn++) {
						var facilities_adjust = (2 * n) + nnn;
						$('ul.facility-list').eq(i).find('article.facility-content').children('a').eq(facilities_adjust).css('height',targetHH);
						$('ul.facility-list').eq(i).find('article.facility-content').children('div.tag-list').eq(facilities_adjust).css('height',targetTagHH);
						$('ul.facility-list').eq(i).find('article.facility-content').children('ul.facility-data-list').eq(facilities_adjust).css('height',targetDataHH);
					}
				}
			}
		}

		//施設一覧アイテムheight 揃え for PC
		if($('ul.facility-list').length){
			$(window).on('load resize', function(){
				facilityListAdjust(0);
			});
		}

		//詳細ページタブ吸着
		/*if($('nav.detail-tabs').length){
			var $detailHeader = $('nav.detail-tabs');
			var windowW = window.innerWidth;
			if(windowW > 768) {} else {
				if(! $detailHeader.find('li:eq(0)').hasClass('is_active') ){
					var position = $('.sticky').offset().top;
					$('body,html').scrollTop(position);
				}
			}

			function adjustDetailHeaderScroll() {
				$detailHeader.find('div.inner').css('margin-left',$('div.inner:first').outerWidth() / -2 );
				var adjustHeight = $detailHeader.find('ul').height();
				$detailHeader.height(adjustHeight);
				$detailHeader.parent('div.detail-tabs-outer').height(adjustHeight);
			}
			adjustDetailHeaderScroll();

			$(window).on('load resize', function(){
				adjustDetailHeaderScroll();
			});
		}*/

		//リスト無限ループ
	$('a#btn_list_more').click(function() {
		if(!($('div.list-loading').length)){
			var index = $('ul.facility-list:hidden').eq(0).index('ul.facility-list');
			$('ul.facility-list:hidden').eq(0).before('<div class="list-loading"></div>');
			setTimeout(function(){
				$('ul.facility-list:hidden').eq(0).css('display','block');
				facilityListAdjust(index);
				$(".list-loading").remove();
				if(($('ul.facility-list:hidden').length) == 0){
					$('a#btn_list_more').off("click").addClass('js-disabled');
				}
			},1000);
			$('ul.facility-list:hidden').eq(0).animate({ opacity: 1 }, { duration: 1750, easing: 'linear' });
		}
		return false;
	});


	/* balloon処理
	*********************************************/
	$('.facility-price-info').on('click',function() {
		$(this).children('.facility-price-balloon').toggleClass('is-active');
	});
	$(window).on('scroll', function(){
		$('.facility-price-balloon').removeClass('is-active');
	});


	/* Topのスライダー高さ揃え処理
	*********************************************/
	function topSliderAutoHeight(){
		var isMobile = $(window).width() < 768;
		$('.js-autoheight').each(function(){
			var target = $(this).find('.js-autoheight-target');
			var maxHeight = 0;
			var targetHeight;
			var hasSPFavBtn = target.eq(0).find(".facility-list-2__favorite-2.js-favorite").length;

			target.each(function(){
				targetHeight = $(this).outerHeight();
				if (maxHeight < targetHeight) {
					maxHeight = targetHeight;
				}
			})
			if (isMobile && hasSPFavBtn) {
				maxHeight += target.eq(0).find(".facility-list-2__favorite-2.js-favorite").outerHeight();
			}
			target.css('height',maxHeight);
		});
	}

	$(window).on('load', function(){
		topSliderAutoHeight();
	});

	$(window).on('resize', function(){
		$('.js-autoheight-target').css('height','auto');
		topSliderAutoHeight();
	});

	/* 検討リストのHTMLアップデート
	*********************************************/
	var favoriteListUpdate = function(){
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				'action' : 'favoriteListUpdate',
			},
			dataType: 'html'
		}).done(function(data) {
      var listSpan = $(data).eq(0).find("span");

			$('.navi__favorite').html(data);
      var favproteListPcDOM = $('.navi__favorite__detail').html();
      $(".sp-favorite__detail").html(favproteListPcDOM);
      $('.navi__favorite-2 span').html(listSpan);
			$('.sp-favorite__detail').html(favproteListPcDOM);
		}).fail(function() {
		});
	}

	favoriteListUpdate();

	/* 検討リストのスマホボタンの処理
	*********************************************/
	$('.js-favorite-sp-btn').on('click',function(){
		$('.js-favorite-sp-detail').fadeToggle();
	});

	/* 検討リストの追加・削除処理
	*********************************************/
	var clickEventType = (( window.ontouchstart!==null ) ? 'click':'touchend');

	$('.js-favorite').on(clickEventType,function(){
		var element = $(this);
		if ( element.hasClass('is-active') ) {
			favoriteDelete(element);
		} else {
			favoriteAdd(element);
		}
	});

	// 追加処理
	var favoriteAdd = function(element){
		var favoriteList = Cookies.get('co-mitFavoriteList');
		var favoriteListParesed = [];
		if (favoriteList) {
			favoriteListParesed = JSON.parse(Cookies.get('co-mitFavoriteList'));
		}
		var targetFacilityId = element.attr('data-facility-id');
		favoriteListParesed.push(targetFacilityId);

		Cookies.set('co-mitFavoriteList', JSON.stringify(favoriteListParesed), { expires: 365 });

		element.addClass('is-active is-balloon');
		favoriteBar();
		favoriteListUpdate();
	}

	// 削除処理
	var favoriteDelete = function(element){
		var favoriteList = Cookies.get('co-mitFavoriteList');
		var favoriteListParesed = [];
		if (favoriteList) {
			favoriteListParesed = JSON.parse(Cookies.get('co-mitFavoriteList'));
		}
		var targetFacilityId = element.attr('data-facility-id');

		for ( var i = 0; i < favoriteListParesed.length; i++ ){
			if (favoriteListParesed[i] == targetFacilityId || favoriteListParesed[i] == null || favoriteListParesed[i] == undefined ) {
				favoriteListParesed.splice(i,1);
				i--;
			}
		}

		Cookies.set('co-mitFavoriteList', JSON.stringify(favoriteListParesed), { expires: 365 });

		element.removeClass('is-active is-balloon');
		favoriteBar();
		favoriteListUpdate();
	}

	// 一覧画面にて、最下段バーの表示・非表示
	var favoriteBar = function(){
		var favoriteList = Cookies.get('co-mitFavoriteList');
		var favoriteListParesed = [];
		if (favoriteList) {
			favoriteListParesed = JSON.parse(Cookies.get('co-mitFavoriteList'));
			console.log(favoriteListParesed)
			if (favoriteListParesed.length > 0) {
				$('.fixed-bar').fadeIn(300);
			} else {
				$('.fixed-bar').fadeOut(300);
			}
		}
	}

	// 検討リストの内容の取得、状態の反映
	var favoriteIconSetting = function(){
		var favoriteList = Cookies.get('co-mitFavoriteList');
		var favoriteListParesed = [];
		if (favoriteList) {
			favoriteListParesed = JSON.parse(Cookies.get('co-mitFavoriteList'));
		}

		$('.js-favorite').removeClass('is-active');
		$('.js-favorite').each(function(){
			var element = $(this);
			var targetFacilityId = element.attr('data-facility-id');

			favoriteListParesed.forEach(function (value, index){
				if (value == targetFacilityId) {
					element.addClass('is-active');
				}
			});

		});

	}

	favoriteIconSetting();

	$(window).on('load',function(){
		favoriteBar();
	});

	// コラムページのタブ切り替え
	$('.js-post-tab-btn').on('click', function(){
		$('.js-post-tab-btn').removeClass('is-tab-active');
		$(this).addClass('is-tab-active');
		$('.js-post-tab-detail').css('display','none');
		$('.post-tab-bar').toggleClass('is-switch');
		var tabNumber = $(this).attr('data-tab-number');
		$('.js-post-tab-detail').each(function(){
		  var tabDetailNumber = $(this).attr('data-tab-number');
		  if ( tabNumber == tabDetailNumber ) {
			$(this).css('display','block');
		  }
		});
	  });

}();


$().fancybox && $(function () {
  $(".js-modal-open").fancybox();
})


$().fancybox && $(function () {
  $(".js-facility-modal-open").fancybox();
})
