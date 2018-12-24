$(function(){
    var timeDown = function(){
        var goalTime = $('.recordgoal');
        var sec = Number(goalTime.text());
        var t1 = setInterval(function(){
            tip();
        },1000) 
        function tip() {
            sec--;
            if (sec < 1){
                clearInterval(t1);
                window.location='http://shop.lunghealthbiotech.com';
            } else {
                goalTime.text(sec);
            }
        }
    }
    timeDown();
}())