$(function(){

var $window = $(window),
		breakPoint = 768, //ブレイクポイントの設定
		winW = $window.width(), //画面の横幅
		winH = $window.height(), //画面の縦幅
		anchorSpeed = 400, //アンカーリンクのスムーズスクロールのスピード
		resizeTimer = false;


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
  var tabTop = 0;
  if($('div').hasClass('tab-area')){
     tabTop = $('.tab-area').offset().top;
  }
$(window).scroll(function (){
	var scroll = $(window).scrollTop();

	/* pagetop show/hidden & facility-list cv fixed btn
	*********************************/
	if (scroll > 500 ){
		$('.pagetop').addClass('is-visible');
	} else {
		$('.pagetop').removeClass('is-visible');
	}
  
  // 詳細ページタブ固定
  //スクロール位置がnavの位置より下だったらクラスfixedを追加
  if(tabTop > 0){
    if(winW <= breakPoint){
      scroll = scroll + 50;
    }
    if (scroll >= tabTop) {
        $('.tab-area').addClass('lock');
    } else if (scroll <= tabTop) {  
        $('.tab-area').removeClass('lock');
    }    
  }
});
 var headerHight = 55; //ヘッダの高さ
 $('a[href^="#"]').click(function() {
  if(winW <= breakPoint){
     var href= $(this).attr("href");
       var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top-headerHight; //ヘッダの高さ分位置をずらす
     $("html, body").animate({scrollTop:position}, 550, "swing");
        return false;
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

/* single 導入部分スライダー
*********************************************/
  if(!$('body div').hasClass('l-body--home')){
    var slider04_swiper = new Swiper('.single-intro__slider', {
      allowTouchMove: false,
      loop: true,
      slidesPerView: 'auto',
      speed: 2000,
      autoplay: {
        delay: 3000,
      },
      effect: "fade",
    });
    // OGP画像設定
    ogp_setting();
  }
  
  var recommend02 = new Swiper('.sonota-list', {
    slidesPerView: 1,
    loop: true,
    //spaceBetween: 19,
    navigation: {
      nextEl: '.sonota-next',
      prevEl: '.sonota-prev',
    },
    breakpoints: {
      769: {
        slidesPerView: 4,
        spaceBetween: 35
      }
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
  $('.question').on('click', function () {
    $(this).parent('div').toggleClass('on');
  //  $(this).toggleClass('on');
  });
  $('.tab__link').on('click', function (e) {
    var target = $(e.currentTarget)
    //タブの表示非表示
    //$('.tab__link').removeClass('on');
    var tabList = document.getElementsByClassName('tab__link');
    for(let i = 0; i < tabList.length; i++) {
      if( tabList.item(i).classList.contains('on')){
        tabList.item(i).classList.remove('on');
      }
      setTimeout(function () {
        tabList.item(i).style.position = 'static';   // .tab-area .tab__linkに対してpositionをstaticにしてからrelativeに戻す処理
        tabList.item(i).style.position = 'relative';
      }, 50);
    }
    target.addClass('on');
    // タブコンテンツトップまでスクロール
    document.getElementById('tab-area').scrollIntoView({behavior: "smooth", block:"start"});
    //タブの中身の表示非表示
    var num = target.data('tab-body');
    $('.tab-content').removeClass('on');
    $('.tab__content' + num).addClass('on');
  })
  $('#map_search').on('click', function () {
    var objCategory = document.form1.category;
    var objPurpose = document.form1.purpose;
    var objTarget = document.form1.target;
    var valCategory = objCategory.options[objCategory.selectedIndex].value;
    var valPurpose = objPurpose.options[objPurpose.selectedIndex].value;
    var valTarget = objTarget.options[objTarget.selectedIndex].value;
    var valTour = '';
    if($("#checkbox__tour").prop("checked") == true){
      valTour = 'モニターツアー実施中';
    }
    var valPayment = '';
    if($("#checkbox__payment").prop("checked") == true){
      valPayment = '補助金対象';
    }
    // 地域ごとに検索タグを設定する
    var mapList = [];
    var resultList = [];
    var targetList = [];
    var key, resultCnt, i;
    mapList.hokkaido = ['ラーニング型','チームビルディング','ビジネス創出型','イノベーションの創出','次世代リーダー育成','SDGs研修','地域交流','経営層・管理職','中堅','若手','意識改革'];
    mapList.city_bibai = ['ビジネス創出型','イノベーションの創出','次世代リーダー育成','SDGs研修','地域交流','経営層・管理職','中堅','若手'];
    mapList.city_chitose = ['ラーニング型','チームビルディング','地域交流','SDGs研修','意識改革','経営層・管理職','中堅','若手'];
    
    mapList.tohoku = ['福利厚生型','ビジネス創出型','ラーニング型','SDGs研修','意識改革','イノベーションの創出','チームビルディング','経営層・管理職','中堅','若手','フィールドメソッド','次世代リーダー育成','ビジョンメイク','地域交流','ワークライフバランスの向上'];
    mapList.city_sendai = ['ラーニング型','SDGs研修','チームビルディング','意識改革','イノベーションの創出','経営層・管理職','中堅','若手'];
    mapList.city_minamisanriku = ['ラーニング型','フィールドメソッド','次世代リーダー育成','意識改革','経営層・管理職','中堅'];
    mapList.city_higashimatsushima = ['ラーニング型','チームビルディング','フィールドメソッド','SDGs研修','次世代リーダー育成','経営層・管理職','中堅','若手'];
    mapList.city_kawasakimachi = ['ラーニング型','地域交流','ビジョンメイク','経営層・管理職','中堅'];
    mapList.city_shiraishi = ['福利厚生型','ワークライフバランスの向上','地域交流','意識改革','経営層・管理職','中堅','若手'];
    mapList.city_shichikashuku = ['福利厚生型','ワークライフバランスの向上','チームビルディング','経営層・管理職','中堅','若手'];
    mapList.city_marumori = ['ビジネス創出型','地域交流','意識改革','イノベーションの創出','経営層・管理職','中堅'];
    mapList.city_natori = ['福利厚生型','ワークライフバランスの向上','地域交流','経営層・管理職','中堅','若手'];
    mapList.city_kamaishi = ['ビジネス創出型','次世代リーダー育成','地域交流','意識改革','フィールドメソッド','経営層・管理職','中堅'];
    
    mapList.koshinetsu= ['ラーニング型', 'チームビルディング','開発合宿','ブレストミーティング','短期集中','経営層・管理職','中堅','若手'];
    mapList.city_tateshina= ['ラーニング型', 'チームビルディング','開発合宿','ブレストミーティング','短期集中','経営層・管理職','中堅','若手'];
    
    mapList.kanto = ['ラーニング型','福利厚生型', 'SDGs研修','意識改革','イノベーションの創出','チームビルディング','経営層・管理職','中堅','チームビルディング','ビジョンメイク','キックオフミーティング','役職・管理者研修','若手','地域交流'];
    mapList.city_minamibousou = ['ラーニング型','チームビルディング','SDGs研修','意識改革','イノベーションの創出','若手','経営層・管理職','中堅'];
    mapList.city_kitakaruizawa = ['ラーニング型','チームビルディング','ビジョンメイク','キックオフミーティング','役職・管理者研修','経営層・管理職','中堅','若手'];
    mapList.city_kamakura = ['福利厚生型','地域交流','イノベーションの創出','経営層・管理職','中堅'];
    
    mapList.tokai = ['福利厚生型','チームビルディング','意識改革','若手','中堅','経営層・管理職'];
    mapList.city_nanao = ['福利厚生型','チームビルディング','意識改革','若手','中堅','経営層・管理職'];

    mapList.kinki = ['福利厚生型', 'チームビルディング','キックオフミーティング','ビジョンメイク','イノベーションの創出','経営層・管理職','中堅','若手','地域交流','ラーニング型','SDGs研修','ラーニング型','フィールドメソッド'];
    mapList.city_odai= ['福利厚生型', 'チームビルディング','キックオフミーティング','ビジョンメイク','イノベーションの創出','経営層・管理職','中堅','若手'];
    mapList.city_kihoku= ['福利厚生型', 'チームビルディング','キックオフミーティング','ビジョンメイク','地域交流','経営層・管理職','中堅','若手'];
    mapList.city_matsusaka= ['ラーニング型', 'チームビルディング','SDGs研修','イノベーションの創出','地域交流','経営層・管理職','中堅','若手'];
    mapList.city_komono= ['福利厚生型', 'チームビルディング','地域交流','経営層・管理職','中堅','若手'];
    mapList.city_shima= ['福利厚生型', 'チームビルディング','キックオフミーティング','ビジョンメイク','経営層・管理職','中堅','若手'];
    mapList.city_toba= ['ラーニング型', 'チームビルディング','フィールドメソッド','イノベーションの創出','ビジョンメイク','経営層・管理職','中堅','若手'];

    mapList.chugoku = ['ビジネス創出型', '地域交流','意識改革','イノベーションの創出','経営層・管理職','中堅','若手','ラーニング型', 'チームビルディング'];
    mapList.city_iwakuni= ['ビジネス創出型', '地域交流','意識改革','イノベーションの創出','経営層・管理職','中堅'];
    mapList.city_ube= ['ビジネス創出型', '地域交流','意識改革','イノベーションの創出','経営層・管理職','中堅'];
    mapList.city_hagi= ['ビジネス創出型', '地域交流','意識改革','イノベーションの創出','経営層・管理職','中堅'];
    mapList.city_nagato= ['ビジネス創出型', '地域交流','意識改革','イノベーションの創出','経営層・管理職','中堅'];
    mapList.city_suouoshima= ['ラーニング型', 'チームビルディング','経営層・管理職','中堅','若手'];
    
    //mapList.shikoku = ['福利厚生型', 'イノベーションの創出'];
    mapList.kyushu = ['ラーニング型', 'SDGs研修','地域交流','イノベーションの創出','チームビルディング','若手','経営層・管理職','中堅'];
    mapList.city_tagawa = ['ラーニング型', 'SDGs研修','地域交流','イノベーションの創出','チームビルディング','若手','経営層・管理職','中堅'];
    //mapList.okinawa = ['福利厚生型', 'キックオフミーティング','補助金対象'];
    
    // 地図クリア
    for (key in mapList){
      $('#map__' + key).removeClass('on');
      $('#' + key).removeClass('on');
    }
    // カテゴリ検索
    if(valCategory != ''){
      for (key in mapList){
        if($.inArray(valCategory, mapList[key]) >= 0){
          resultList.push(key);
        }
      }
    }
    // 課題・目的検索
    if(valPurpose != '' && resultList.length > 0){
      resultCnt = resultList.length;
      targetList = $.extend(true, {}, resultList);
      for(i=0;i<resultCnt;i++){
        if($.inArray(valPurpose, mapList[targetList[i]]) == -1){
          resultList.splice($.inArray(targetList[i], resultList),1);
        }                   
      }
    }else{
      for (key in mapList){
        if($.inArray(valPurpose, mapList[key]) >= 0 && !resultList.includes(key)){
          resultList.push(key);
        }      
      }
    }
    // 対象検索
    if(valTarget != '' && resultList.length > 0){
      resultCnt = resultList.length;
      targetList = $.extend(true, {}, resultList);
      for(i=0;i<resultCnt;i++){
        if($.inArray(valTarget, mapList[targetList[i]]) == -1){
          resultList.splice($.inArray(targetList[i], resultList),1);
        }                   
      }
    }else{
      for (key in mapList){
        if($.inArray(valTarget, mapList[key]) >= 0 && !resultList.includes(key)){
          resultList.push(key);
        }      
      }
    }
    // モニターツアー実施中検索
    if(valTour != '' && resultList.length > 0){
      resultCnt = resultList.length;
      targetList = $.extend(true, {}, resultList);
      for(i=0;i<resultCnt;i++){
        if($.inArray(valTour, mapList[targetList[i]]) == -1){
          resultList.splice($.inArray(targetList[i], resultList),1);
        }                   
      }
    }else{
      for (key in mapList){
        if($.inArray(valTour, mapList[key]) >= 0 && !resultList.includes(key)){
          resultList.push(key);
        }      
      }
    }
    // 補助金対象検索
    if(valPayment != '' && resultList.length > 0){
      resultCnt = resultList.length;
      targetList = $.extend(true, {}, resultList);
      for(i=0;i<resultCnt;i++){
        if($.inArray(valPayment, mapList[targetList[i]]) == -1){
          resultList.splice($.inArray(targetList[i], resultList),1);
        }                   
      }
    }else{
    for (key in mapList){
        if($.inArray(valPayment, mapList[key]) >= 0 && !resultList.includes(key)){
          resultList.push(key);
        }      
      }
    }
    // 全件検索
    if(valCategory == '' && valPurpose == '' && valTarget == '' && valTour == '' && valPayment == ''){
      for (key in mapList){
        resultList.push(key);
      }
      
    }
    // 対応する地域に色を付ける
    for(var i in resultList){
      $('#map__' + resultList[i]).addClass('on');
      $('#' + resultList[i]).addClass('on');
    }
  });

  // スライド画像の1枚目をOGP画像に設定
  function ogp_setting() {
    var image = $('.slide_img01').attr('src')
    var headData = document.head.children;
    for (var i = 0; i < headData.length; i++) {
      // OGPの設定
      var propertyVal = headData[i].getAttribute('property');
      if(propertyVal !== null) {
        if(propertyVal.indexOf('og:image') != -1) {

          headData[i].setAttribute('content', image);
        }
      }
    }
  } 
  
});