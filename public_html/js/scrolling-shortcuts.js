$(function(){
 $(document).ready(function() {
    var offset = 220;
    var duration = 500;

    var $header = $("header");


    $header.unstick = function(){
      var height = $(this).css('height');

      $(this).animate({top:'-'+height},300,function(){
      $header.removeClass("header-fixed-top");
        $header.prev().css('margin-bottom','0');
        $('.back-to-search').css('visibility','visible');
      });

    };

    $header.stick = function(){

      var height = $(this).css('height');

      $(this).addClass("header-fixed-top");
      $(this).prev().css('margin-bottom',height);
      $header.css("top",'0');
      $header.css("opacity",0);

      setTimeout(function(){
        $header.css("opacity",1);
        $header.css("top",'-'+height);
        $('.back-to-search').css('visibility','hidden');
        $header.animate({top:'0px'},300,function(){

        });
      },100);
    };


    $(window).scroll(function() {
      if ($(this).scrollTop() > offset) {
        $('.scroll-shortcut').fadeIn(duration);
      } else {
        $('.scroll-shortcut').fadeOut(duration);
        $header.unstick();
      }
    });

    $('a.scroll-shortcut').click(function(event) {
      event.preventDefault();
      $('html, body').animate({scrollTop: 0}, duration);
      return false;
    })

    var blurEnabled = true;

    $("#search").blur(function(){
      if ( blurEnabled )
        $header.unstick();
    }).keydown(function(e){
      if ( e.keyCode == 27 ) $(this).blur();
    });

    $('.back-to-search').mousedown(function(){
      blurEnabled = false;
    }).mouseleave(function(){
      blurEnabled = true;
    }).click(function(event) {

      event.preventDefault();
      var id =$(this).attr("for");

      $header.stick();

      $("#"+id).focus();
      $("#"+id).select();

      blurEnabled = true;

      return false;
    })
  });
});