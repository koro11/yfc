//lunbotu
var _orders = $("#get_orders").val(); //index/get_orders
var foodurl = $("#foodurl").val();    //index/s_food
var shopurl = $("#shopurl").val();    //index/s_shop
var cateurl = $("#cateurl").val();    //index/get_cate

$(function() {

    var Page = (function() {

        var $navArrows = $( '#nav-arrows' ).hide(),
            $navDots = $( '#nav-dots' ).hide(),
            $nav = $navDots.children( 'span' ),
            $shadow = $( '#shadow' ).hide(),
            slicebox = $( '#sb-slider' ).slicebox( {
                onReady : function() {

                    $navArrows.show();
                    $navDots.show();
                    $shadow.show();

                },
                onBeforeChange : function( pos ) {

                    $nav.removeClass( 'nav-dot-current' );
                    $nav.eq( pos ).addClass( 'nav-dot-current' );

                },
                orientation : 'r',
                cuboidsRandom : true
            } ),

            init = function() {

                initEvents();

            },
            initEvents = function() {
                // add navigation events
                $navArrows.children( ':first' ).on( 'click', function() {
                    slicebox.next();
                    return false;

                } );

                $navArrows.children( ':last' ).on( 'click', function() {

                    slicebox.previous();
                    return false;

                } );

                $nav.each( function( i ) {

                    $( this ).on( 'click mouseover', function( event ) {

                        var $dot = $( this );

                        if( !slicebox.isActive() ) {

                            $nav.removeClass( 'nav-dot-current' );
                            $dot.addClass( 'nav-dot-current' );

                        }

                        slicebox.jump( i + 1 );
                        return false;

                    } );

                } );


            };

        return { init : init };

    })();

    Page.init();

    //自动轮播
    function auto() {
        $("#next").click();
    }
    tttt=setInterval(auto,5000);
    $(".other").click(function(){
        setTimeout(tttt,5000);
    })
    $( '#nav-dots' ).children( 'span' ).mouseover(function(){
        clearInterval(tttt);
    })
    $( '#nav-dots' ).children( 'span' ).mouseout(function(){
        tttt = setInterval(auto,5000);
    })
    $(".sb-slider").children( 'li' ).mouseover(function(){
        clearInterval(tttt);
    })
    $(".sb-slider").children( 'li' ).mouseout(function(){
        tttt = setInterval(auto,5000);
    })

    // 第一个点默认选中
    $("#nav-dots").children('span').eq(0).addClass(' nav-dot-current');
});

//get_orders
var UpRoll = document.getElementById('UpRoll');
var lis = UpRoll.getElementsByTagName('li');
var ml = 0;
var timer1 = setInterval(function(){
    // var liHeight = lis[0].offsetHeight;
    var timer2 = setInterval(function(){
        UpRoll.scrollTop = (++ml);
        if(ml ==1){
            clearInterval(timer2);
            UpRoll.scrollTop = 0;
            ml = 0;
            lis[0].parentNode.appendChild(lis[0]);
        }
    },10);
},5000);

//订单
function get_orders() {
    $.ajax({
        type: "GET",
        url: _orders,
        success: function(msg){
            $("#UpRoll").html(msg);
        }
    });
}
get_orders();
// setInterval(get_orders,5000);

//菜品分类 &&　商家分类
function get_cate(type){
    $.ajax({
        type: "POST",
        url: cateurl,
        data: {type:type},
        success: function(msg){
           $(".fodcate").html(msg);
           $(".class_B").children('a').remove();
           $(".class_B").prepend('<a class="close" href="javascript:void(0);" cate_id="">全部<img src="./images/ch.png"></a>');
        }
    });
}

//菜品
function get_foods(cate_id,d_id) {
    $.ajax({
        type: "POST",
        url: foodurl,
        data: {cate_id:cate_id,d_id:d_id},
        success: function(msg){
            $(".SCcontent").html(msg);
        }
    });
}

//店铺
function get_merchant(cate_id,d_id) {
    $.ajax({
        type: "POST",
        url: shopurl,
        data: {cate_id:cate_id,d_id:d_id},
        success: function(msg){
            $(".DCcontent").html(msg);
        }
    });
}


$(function(){
    //遮罩层
    $(".showbtn").click(function () {
        $("#bg").css({
            display: "block", height: $(document).height()
        });
        var $box = $('.box');
        $box.css({
            //设置弹出层距离左边的位置
            left: ($("body").width() - $box.width()) / 2 - 20 + "px",
            //设置弹出层距离上面的位置
            top: ($(window).height() - $box.height()) / 2 + $(window).scrollTop() + "px",
            display: "block"
        });
    });
        //点击关闭按钮的时候，遮罩层关闭
    $(document).on('click','.close',function () {
        $("#bg,.box").css("display", "none");
    })

    // //选择分类到页面
    // $(".selectcate").click(function(){
    //     var cate ='';
    //     for (var i=0;i<$(".fodcate").find('a').size();i++){
    //         if ($(".fodcate").find('a').eq(i).hasClass('checked')){
    //             cate = $(".fodcate").find('a').eq(i);
    //         }
    //     }
    //     // cate.children('img').remove();
    //     cate.removeClass("checked");
    //     $(".fodcate").append($(".class_B").children('a'));
    //     // $(".class_B").children('a').remove();
    //     $(".class_B").prepend(cate);
    // });


    //地区 分类 的选择
    $(document).on('click','.seekarea a',function () {
        if ($(this).hasClass("checked")) {
            $(this).removeClass("checked");
        }else{
            $(this).addClass("checked").siblings().removeClass("checked");
        }

        //选择分类到页面
        if ($(this).hasClass('close')){
            var  cate = $(this);
            cate.removeClass("checked");
            $(".fodcate").append($(".class_B").children('a'));
            $(".class_B").prepend(cate);
        }

        var cate_id = $(".class_B").children('a').attr('cate_id'); //获取分类id
        var d_id = '';
        //每一次点击判断是否选择地区 选择就去获取地区id
        for (var i=0;i<$(".foodaddress a").size();i++){
            if ($(".foodaddress a").eq(i).hasClass('checked')){
                d_id = $(".foodaddress a").eq(i).attr('d_id');
            }
        }
        //判断当前是点菜还是餐馆
        var _type = $("#Indextab").children('li');
        for (var i=0;i<_type.length;i++){
            if (_type.eq(i).hasClass('current')){
                var thistype = _type.eq(i).html();
            }
        }
        if (thistype == '点菜'){
            get_foods(cate_id,d_id);
        }else{
            get_merchant(cate_id,d_id);
        }


    });

    $("#Indextab").children('li').click(function(){
        var _type=$(this).html();
        if (_type == '点菜'){
            get_cate(1);
        }else{
            get_cate(2);
        }

    })


    //订单轮播

    var oi = 0; //jishu
    var oclone = $(".Orderlist li").first().clone();//克隆第一张图片
    $(".Orderlist").append(oclone);//复制到列表最后
    var osize = $(".Orderlist li").size();

    /*自动轮播*/
    var ot = setInterval(function () { oi++; omove();},2000);
    /*移动事件*/
    function omove() {
        if (oi == osize) {
            $(".Orderlist").css({ top: 0 });
            oi = 1;
        }
        $(".Orderlist").stop().animate({ top: -oi * 89 }, 500);
    }


    //用户菜品点评轮播
    var i = 0; //jishu
    var clone = $(".usercomment ul li").first().clone();//克隆第一张图片
    $(".usercomment ul").append(clone);//复制到列表最后
    var size = $(".usercomment ul li").size();

    /*自动轮播*/
    var t = setInterval(function () { i++; move();},2000);
    /*移动事件*/
    function move() {
        if (i == size) {
            $(".usercomment ul").css({ top: 0 });
            i = 1;
        }
        $(".usercomment ul").stop().animate({ top: -i * 95 }, 500);
    }


})