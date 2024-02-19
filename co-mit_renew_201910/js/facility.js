/* facilityページにて、sp版の場合、ヘッダー固定を解除する
*********************************************/
$(function(){
  $('body').addClass('head-fixed-cancel');
});

/* stickyHeaderの横スクロールを可能にする
*********************************************/
$(window).on("scroll", function(){
  var $tab_outer = $('.detail-tabs-outer');

  if ( $tab_outer.hasClass('fixed') ) {
    $(".detail-tabs-outer.fixed").css("left", -$(window).scrollLeft());

  } else {
    $tab_outer.css({
     'left': 0
   });
  }
});