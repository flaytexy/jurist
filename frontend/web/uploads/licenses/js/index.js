var timer;
$(".perso ul li").mouseenter(function() {
    var that = this;
    timer = setTimeout(function(){
        $('.perso ul li').removeClass('hovered').addClass('adapt');
        $(that).addClass('hovered');
    }, 300);
}).mouseleave(function() {
    clearTimeout(timer);
});


$('.perso ul li:nth-of-type(1)').click(function(){
   $('.perso').fadeOut(800);
    $('article:nth-of-type(1)').delay( 200 ).fadeIn(1000);
});
$('.perso ul li:nth-of-type(2)').click(function(){
   $('.perso').fadeOut(800);
    $('article:nth-of-type(2)').delay(500).fadeIn(800);
});
$('.perso ul li:nth-of-type(3)').click(function(){
   $('.perso').fadeOut(800);
    $('article:nth-of-type(3)').delay(200).fadeIn(1000);
});
$('.perso ul li:nth-of-type(4)').click(function(){
   $('.perso').fadeOut(800);
    $('article:nth-of-type(4)').delay(300).fadeIn(1000);
});


$('.close').click(function(){
    $('article').fadeOut(800);
  $('.perso').delay(300).fadeIn(800);
});
