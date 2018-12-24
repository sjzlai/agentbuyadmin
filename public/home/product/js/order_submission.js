$(function(){
    var t = $("#order_submission").find(".plus").parent().find("input"),
        i = Number(t.val()),     
        o = $(".sub_describe").find(".price").data("price"),
        a = $(".sub_describe").find("a"),
        p = $(".total_price").find("span").find(".total_input"),
        c = $(".total_money"),
        n = $(".discount_price"),
        d = Number(n.val()),
        b = $(".bottom_price");
        b.text("￥" +Number(o*i-d).toFixed(2)),
        j = Number(o*i).toFixed(2);
        p.val(j);
        c.text(j);
        $(".sub_describe").find(".price").text('￥'+o);

    $("#order_submission").find(".plus").click(function(){
        i += 1,t.val(i),
        j = Number(o*i).toFixed(2),
        p.val(j),c.text("￥"+j),
        b.text("￥" +Number(o*i-d).toFixed(2));
    });
    $("#order_submission").find(".reduce").click(function(){
        i<=1?t.val(1):(i-=1,t.val(i)),
        j = Number(o*i).toFixed(2),
        p.val(j),c.text("￥"+j),
        b.text("￥" +Number(o*i-d).toFixed(2));
    });
    n.on('keyup',function(){
        d = $(this).val(),
        d<=0?n.val(0):(n.val(d)),
        b.text("￥" +Number(o*i-d).toFixed(2)),
        n.val(d);
    })
    t.on('keyup',function(){
        i = $(this).val(),
        i<=1?t.val(1):(t.val(i)),
        j = Number(o*i).toFixed(2),
        p.val(j),c.text("￥"+j),
        b.text("￥" +Number(o*i-d).toFixed(2)),
        t.val(i);
    })

}())
