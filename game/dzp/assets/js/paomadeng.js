/**
*@author 大灰狼 
*@email 116311316@qq.com
*@version 1.1
*/
var paomadeng={
	 index : 1, //起点
	 speed : 400, //初始速度
	 roll:0, //定时器id
	 cycle : 1, //已跑的圈速
	 times : 4, //至少跑几圈
	 prize : -1, //中奖索引
	 btn:0,
     txt:0,
	run : function () {
		var before = paomadeng.index == 1 ? 12 : paomadeng.index - 1; //12 表示最大的奖项索引,1表示最小的奖项索引
		$("li[data-index='" + paomadeng.index + "']").addClass("active");
		$("li[data-index='" + before + "']").removeClass("active");

		//初步加快的过程
		paomadeng.upSpeed();
		paomadeng.downSpeed();
		paomadeng.index += 1;
		paomadeng.index = paomadeng.index == 13 ? 1 : paomadeng.index;
	},
	//提速 -- 当已跑的圈数cycle小于2时，提速
	upSpeed : function () {
		if (paomadeng.cycle < 2 && paomadeng.speed > 100) {
			paomadeng.speed -= paomadeng.index * 8;
			paomadeng.stop();
			paomadeng.start();
		}
	},
	//降速
	downSpeed:function () {
		if (paomadeng.index == 11) {
			paomadeng.cycle += 1; //圈数+1
		}

		if (paomadeng.cycle > paomadeng.times - 1 && paomadeng.speed < 400) {
			paomadeng.speed += 20;
			paomadeng.stop();
			paomadeng.start();
		}

		if (paomadeng.cycle > paomadeng.times && paomadeng.index == paomadeng.prize) {
			paomadeng.stop();
		    paomadeng.showPrize();
		}
	},
	//先停止再显示结果 按钮显示出来
	showPrize:function(){
        clearInterval(paomadeng.roll);
		setTimeout(function(){
			alert(paomadeng.txt);
			paomadeng.btn.show();
		},700);
        clearInterval();
	},

	//重新开始
	reset : function () {
		paomadeng.btn=$(this);
		paomadeng.btn.hide();
		paomadeng.speed = 400;
		paomadeng.cycle = 0;

        //获取中奖id
        if(paomadeng.prize==-1){
            paomadeng.prize = Math.round(Math.random() * 11) + 1;
        }
		paomadeng.run();
	},
    //定时run
	start : function () {
		paomadeng.roll = setInterval(paomadeng.run, paomadeng.speed);
	},

    //清除定时
	stop : function () {
		clearInterval(paomadeng.roll);
	}
}
