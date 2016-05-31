function loading(canvas, options) {
	this.canvas = canvas;
	if (options) {
		this.radius = options.radius || 12;
		this.circleLineWidth = options.circleLineWidth || 4;
		this.circleColor = options.circleColor || 'lightgray';
		this.moveArcColor = options.moveArcColor || 'gray';
	} else {
		this.radius = 12;
		this.circelLineWidth = 4;
		this.circleColor = 'lightgray';
		this.moveArcColor = 'gray';
	}
}
loading.prototype = {
	show: function() {
		var canvas = this.canvas;
		if (!canvas.getContext) return;
		if (canvas.__loading) return;
		canvas.__loading = this;
		var ctx = canvas.getContext('2d');
		var radius = this.radius;
		var me = this;
		var rotatorAngle = Math.PI * 1.5;
		var step = Math.PI / 6;
		canvas.loadingInterval = setInterval(function() {
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			var lineWidth = me.circleLineWidth;
			var center = {
				x: canvas.width / 2,
				y: canvas.height / 2
			};

			ctx.beginPath();
			ctx.lineWidth = lineWidth;
			ctx.strokeStyle = me.circleColor;
			ctx.arc(center.x, center.y + 20, radius, 0, Math.PI * 2);
			ctx.closePath();
			ctx.stroke();
			//在圆圈上面画小圆   
			ctx.beginPath();
			ctx.strokeStyle = me.moveArcColor;
			ctx.arc(center.x, center.y + 20, radius, rotatorAngle, rotatorAngle + Math.PI * .45);
			ctx.stroke();
			rotatorAngle += step;
		},
		100);
	},
	hide: function() {
		var canvas = this.canvas;
		canvas.__loading = false;
		if (canvas.loadingInterval) {
			window.clearInterval(canvas.loadingInterval);
		}
		var ctx = canvas.getContext('2d');
		if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
	}
};

var goon = true;
var zjl = false;
var num = 0;
$(function() {
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
	var ggl = {
		'id'	:	1,
		'title' :	'刮刮乐',
		'content' : '中奖率高达80%的活动哦，还等什么，赶紧来刮刮乐吧',
		'endtime' : '2016-06-01',
		'prize'	:	prize,
		'prizelog' : prizelog,
		'myprizelog' : myprizelog,
		'remainnum' : 30
	};
	var tpl = _.template($("#ggl_tpl").html());
	var html = tpl({'act':ggl});
	$("#ggl").after(html);
	//
	
	$("#scratchpad").wScratchPad({
		width: 150,
		height: 40,
		color: "#a9a9a7",
		scratchMove: function() {
			num++;
			if(num>20 && goon){
				$.getJSON("act_prize.json?aid=2&uid=1", function (data) {
					if (data.msg === 1) {
						$("#prize").html(data.prize);
						$("#theAward").html(data.prize);
						$("#sncode").html(data.prize_code);
						$("#zjl").slideToggle(1000);
					} else {
						$("#prize").html(data.prize);
						//location.reload();
					};
				});
				goon = false;
			}
		}
	});
});