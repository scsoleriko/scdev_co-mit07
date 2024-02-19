$(function(){
  $('.sp-circular__btn').click(function(){
    $(this).toggleClass('open');
    $('.circular-header .l-wrapper').toggleClass('open');
  });

  // スムーズスクロール
	var headerHeight = $('header').height();
	var urlHash = location.hash;

	if(urlHash) {
		$('body,html').stop().scrollTop(0);

		setTimeout(function(){
			let target = $(urlHash);
			if ($(target).length) {
				let position = target.offset().top - headerHeight;
				$('body,html').stop().animate({scrollTop:position}, 500);
			};
		}, 100);
	}

	$('a[href^="#"]').click(function() {
		var href = $(this).attr("href");
		var target = $(href == "#" || href == "" ? "html" : href);
		if ($(target).length) {
			var position = target.offset().top - headerHeight ;
			$("html, body").stop().animate({scrollTop:position}, 500, "swing");
			return false;
		};
	});
});