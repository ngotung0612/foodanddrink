pos = $("#menutop").position();
$(window).scroll(function(){
    var posScroll = $(document).scrollTop();
    if (parseInt(posScroll) > parseInt(pos.top)) {
        $("#menutop").addClass('fixed');
        $("#menutop").addClass('fixed1');
    } else{
        $("#menutop").removeClass('fixed');
        $("#menutop").removeClass('fixed1');
    }
})