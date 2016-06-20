
$(function () {
	//初始化参数
	var prize = [
				{'id':'1', 'title':'一等奖', 'awardname':'Ipad Air', 'num':'10' }, 
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
	var zjd = {
		'id'	:	1,
		'title' :	'砸金蛋',
		'content' : '中奖率高达80%的活动哦，还等什么，赶紧来砸金蛋吧',
		'endtime' : '2016-06-01',
		'prize'	:	prize,
		'prizelog' : prizelog,
		'myprizelog' : myprizelog,
		'remainnum' : 30
	};
	var tpl = _.template($("#zjd_tpl").html());
	var html = tpl(zjd);
	$("#banner").after(html);
	
	//
	var timer, forceStop;
	var wxch_Marquee = function (id) {

		var container = document.getElementById(id),
			original = container.getElementsByTagName("dt")[0],
			clone = container.getElementsByTagName("dd")[0],
			speed = arguments[1] || 10;
		clone.innerHTML = original.innerHTML;
		var rolling = function () {
			if (container.scrollLeft == clone.offsetLeft) {
				container.scrollLeft = 0
			} else {
				container.scrollLeft++
			}
		};
		this.stop = function () {
			clearInterval(timer)
		};
		timer = setInterval(rolling, speed);
		container.onmouseover = function () {
			clearInterval(timer)
		};
		container.onmouseout = function () {
			if (forceStop) return;
			timer = setInterval(rolling, speed)
		}
	};
	var wxch_stop = function () {
		clearInterval(timer);
		forceStop = true
	};
	var wxch_start = function () {
		forceStop = false;
		wxch_Marquee("banner", 20)
	};
	wxch_Marquee("banner", 20);
	var $egg;
	$("#banner a").on('click', function () {
		wxch_stop();
		$egg = $(this);
		var offset = $(this).position(),
			$hammer = $("#hammer");
		$hammer.animate({
			left: (offset.left + 30)
		}, 1000, function () {
			$(this).addClass('hit');
			$("#f").css('left', offset.left).show();
			$egg.find('img').attr('src', 'assets/images/egg2.png');
			setTimeout(function () {
				act_result.call(window)
			}, 500)
		})
	});
	$("#mask").on('click', function () {
		$(this).hide();
		$("#dialog").hide();
		$egg.find('img').attr('src', 'assets/images/egg.png');
		$("#f").hide();
		$("#hammer").css('left', '-74px').removeClass('hit');
		wxch_start()
	});
	$("#close").click(function () {
		$("#mask").trigger('click')
	});
	function act_result() {
		$.getJSON("act_prize.json?aid=1uid=1", function (data) {
			$("#mask").show();
			if (data.msg === 1) {
				$("#content").html("恭喜你获得<br>"+data.prize+"<br>请在我的中奖纪录中<br>凭借兑奖码联系我们兑奖");
				$("#dialog").attr("class", 'yes').show();
				$(".num").text(data.num - 1);
				//setTimeout(function () {location.reload()}, 6000)//yyy添加
			} else if (data.msg === 0) {
				$("#content").html(data.prize);
				$("#dialog").attr("class", 'no').show();
				$(".num").text(data.num - 1);
			} else if (data.msg == 2) {
				$("#content").html(data.prize);
				$("#dialog").attr("class", 'no').show()
			};
		})
	}
});
