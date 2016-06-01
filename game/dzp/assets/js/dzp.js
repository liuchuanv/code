
$(function(){
    //初始化参数
    //奖项
    var prize = [
        {'id':'1', 'title':'一等奖', 'awardname':'Ipad Air', 'num':'10' },
        {'id':'2', 'title':'二等奖', 'awardname':'Itouch', 'num':'50' },
        {'id':'3', 'title':'三等奖', 'awardname':'300元优惠券', 'num':'100' },
    ];
    //获奖记录
    var prizelog = [
        {'uname':'张三', 'awardname':'300元优惠券', 'addtime':'2016-04-30 12:39'},
        {'uname':'李四', 'awardname':'Itouch', 'addtime':'2016-04-30 12:00'},
        {'uname':'王五', 'awardname':'300元优惠券', 'addtime':'2016-04-30 11:27'},
    ];
    //我的获奖记录
    var myprizelog = [
        {'uname':'张三', 'awardname':'300元优惠券', 'addtime':'2016-04-30 12:39'},
    ];
    var dzp = {
        'id'	:	1,
        'title' :	'大转盘',
        'content' : '中奖率高达80%的活动哦，还等什么，赶紧来砸金蛋吧',
        'endtime' : '2016-06-01',
        'prize'	:	prize,
        'prizelog' : prizelog,
        'myprizelog' : myprizelog,
        'remainnum' : 30
    };

    $("#start").bind('click',function(){
        $.getJSON("act_prize.json?aid=1uid=1", function (data) {
            paomadeng.txt = "恭喜你，获得了" + data.prize;
            paomadeng.prize = data.msg;
            paomadeng.gameover = function(){
                $("#mask").show();
                if (data.msg === 1) {
                    $("#content").html("恭喜你获得<br>"+data.prize+"<br>请在我的中奖纪录中<br>凭借兑奖码联系我们兑奖");
                    $("#dialog").attr("class", 'yes').show();
                } else if (data.msg === 0) {
                    $("#content").html(rst.prize);
                    $("#dialog").attr("class", 'no').show();
                } else if (data.msg == 2) {
                    $("#content").html(data.prize);
                    $("#dialog").attr("class", 'no').show()
                };
            }
            paomadeng.reset();
        })

    });

    $("#mask").on('click', function () {
        $(this).hide();
        $("#dialog").hide();
    });
    $("#close").click(function () {
        $("#mask").trigger('click')
    });
});
