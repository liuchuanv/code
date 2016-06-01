
$(function() {
    //初始化参数
    var prize = [
        {'id':'1', 'title':'一等奖', 'awardname':'Ipad Air', 'num':'110' },
        {'id':'2', 'title':'二等奖', 'awardname':'Itouch', 'num':'50' },
        {'id':'3', 'title':'三等奖', 'awardname':'300元优惠券', 'num':'100' },
    ];
    var prizelog = [
        {'uname':'张三', 'awardname':'300元优惠券', 'addtime':'2016-04-30 12:39'},
        {'uname':'李四', 'awardname':'Itouch', 'addtime':'2016-04-30 12:00'},
        {'uname':'王五', 'awardname':'300元优惠券', 'addtime':'2016-04-30 11:27'},
    ];
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
    var tpl = _.template($("#dzp_tpl").html());
    var html = tpl({act : dzp});
    $("#banner").after(html);

	var data = [
		{ type : 1 ,msg :'一等奖'},
		{ type : 0 ,msg : '谢谢参与'},
		{ type : 0 ,msg : ''},
		{ type : 0 ,msg : '要加油哦'},
		{ type : 1 ,msg : '三等奖'},
		{ type : 0 ,msg : '运气不够'},
		{ type : 0 ,msg : ''},
		{ type : 0 ,msg : '再接再厉'},
		{ type : 1 ,msg : '二等奖'},
		{ type : 0 ,msg : '祝你好运'},
		{ type : 0 ,msg : ''},
		{ type : 0 ,msg : '不要灰心'}
	]

	var tt = null;
	$("#zhen").click(function() {
		// 显示结果
		var $me = $(this);
		$.getJSON("act_prize.json?aid=x", function(json){
			if(json.msg == 2){
				$("#content").html(json.prize);
				$("#dialog").attr("class",'no').show();
			}else{
				var r = 1440 + 30*(json.r-1);
				var style ;
				style = '-webkit-transition-delay:1s;-webkit-transition: all 3s;transition: all 3s;-webkit-transform: rotate('+r+'deg);'+'-moz-transition-delay:1s;-moz-transition: all 3s;transition: all 3s;-moz-transform: rotate('+r+'deg);'+'transition-delay:1s;transition: all 3s;transition: all 3s;transform: rotate('+r+'deg);'+'filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);';
				$me.attr('style',style);
				wxch_show(json);
				if(json.num >= 1){
					$(".num").text(json.num-1);
				}else{
					$(".num").text(json.num);
				}
			}
		});
	});

	function wxch_show (json) {
		var angle = 30*(json.r-1);
		setTimeout(function() {
			$("#mask").show();
			$("#zhen").attr('style','-webkit-transform: rotate('+angle+'deg);-moz-transform: rotate('+angle+'deg);transform: rotate('+angle+'deg);')
			if (json.msg == 1) {
				$("#content").html(json.prize);
				$("#dialog").attr("class",'yes').show();
			}else {
				$("#content").html(json.prize);
				$("#dialog").attr("class",'no').show();
			}
		}, 3000);
	}

	$("#mask").on('click',function() {
		$(this).hide();
		$("#dialog").hide();
	});

	$("#close").click(function() {
		$("#mask").trigger('click');
	});
});