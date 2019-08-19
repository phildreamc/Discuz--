$(function () {
    // 首页轮播
    var idx = 0;
    var $imgs = $('.banner-img-box a');
    var $btns = $('.adv-btns a');
    var interval = 4000;
    var duration = 400;
    var timerLun;

    function changeIdx() {
        idx += 1;
        idx == $imgs.length && (idx = 0);
    }

    function updataView() {
        imgRset();
        $imgs[idx].style.display = 'block';
        $btns.eq(idx).addClass('active').siblings().removeClass('active');
    }
    
    function imgRset(){
        for (var i = 0; i < $imgs.length; i++){
            $imgs[i].style.display = 'none';
        }
    }
    
    function slide() {
        changeIdx();
        updataView();
    }
    
    updataView();
    timerLun = setInterval(slide, interval);
    
    $('.banner-img-box').hover(function () {
        clearInterval(timerLun);
        timerLun = null
    }, function () {
        timerLun = setInterval(slide, interval);
    });
    
    $btns.mouseenter(function () {
        idx = $(this).index();
        updataView()
    });
    
    // 首页公告
    var widths = 0;
    var l = 0;
    var $ans = $('.temWrap');
    var scrollRun;
    
    $(".temWrap ul li").each(function(){
        widths += $(this).width() + 20;
    });
    
    console.log('widths:' + widths);
    function changeL() {
        l -= 2;
        if (l + widths/2 < 0){
            l = 0;
        }
    }
    
    function an_scroll(){
        $ans[0].style.marginLeft = l + 'px';
        changeL();
    }
    
    scrollRun = setInterval(an_scroll, 50);
    
    $('.bd').hover(function () {
        clearInterval(scrollRun);
        scrollRun = null
    }, function () {
        scrollRun = setInterval(an_scroll, 50);
    });
});