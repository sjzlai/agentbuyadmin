$(function(){
    var bullet = function bullet(){
        var triggerSpan = $('.express_num>span.trigger_span');
        var closeType = $('.chose_type>span:last-child>a');
        var showType = $('.fade');
        triggerSpan.on('click',function(e){
            e.preventDefault();
            showType.css({
                display: 'block'
            });
        });
        closeType.on('click',function(e){
            e.preventDefault();
            showType.css({
                display: 'none'
            });
        })
    }
    bullet();

    var showRec = function showRec(){
        var rec = $('.record_title>div:not(:last-child)').find('.rec');
        rec.on('click',function(e){
            e.preventDefault();
            $(this).addClass('active').parent().siblings().find('.rec').removeClass('active');
        })
    }
    showRec();

    var countDown = function countDown(){
        var yzm = $('.codePhone');
        function canClick(){
            yzm.removeAttr("disabled");
        }
        yzm.on('click',function(){
            $(this).attr("disabled","disabled");
            var sec = 60;
            tip();
            var t1 = setInterval(function(){
                tip();
            },1000)
            function tip() {
                sec--;
                if (sec < 1) {
                    yzm.text('重发验证码');
                    clearInterval(t1);
                    canClick();
                } else {
                    yzm.text(sec+"(s)");
                }
            }
        })
    }
    countDown();

    var changeRec = function changeRec(){
        var orders = $('.record_title>div:not(:last-child)');
        var nam = '';
        if(orders.find('a').hasClass('.avtive')){
            nam = orders.find('a.active').parent().attr('class');
            $('#'+nam).css({
                display:'block'
            }).siblings().css({
                display:'none'
            })
        }else{
            $('#record_all').css({
                display:'block'
            }).siblings().css({
                display:'none'
            })
        }
        orders.on('click',function(){
            nam = $(this).attr('class');
            $('#'+nam).css({
                display:'block'
            }).siblings().css({
                display:'none'
            })
        })
    }
    changeRec();

}())
