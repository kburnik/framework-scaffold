$(function(){
  $("body").on("click", ".phone-button",function(event) {
    $(event.target).toggleClass("active");
  });

  $("body").on("click", ".scroll-shortcut.back-to-top", function(event) {
    event.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  $("body").on("click", ".scroll-shortcut.back-to-search", function(event) {
    event.preventDefault();
    $('html, body').animate({
      scrollTop: $("#search").offset().top
    }, "slow");
    $($("#search input[type=text]")[0]).focus();
  });

  $(window).on("scroll", function(event){
    var top = $(window).scrollTop();
    if(top == 0) {
      $(".scroll-shortcut.back-to-top, .scroll-shortcut.back-to-search")
        .css({"display": "none"});
    } else {
      $(".scroll-shortcut.back-to-top, .scroll-shortcut.back-to-search")
        .css({"display": "block"});
    }
  });

  // TODO(kburnik): move to js/search.js
  if ($('.datetimepicker').length > 0) {
    $('.datetimepicker').datetimepicker({
      language: 'hr',
      pick12HourFormat: false
    })
  }

  $(".modal").modal();
});
