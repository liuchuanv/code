
/**
 * 抛物线插件
 * @参数 flyItem	target	speed	curvature	complete
 * 
 */
$(function(){
	var myParabola = function(obj,opt){
		opt.flyItem.style.display = "none"
		var parabolaFun = funParabola(opt.flyItem, opt.target, {
							speed : opt.speed, //抛物线速度
							curvature : opt.survature, //控制抛物线弧度
							complete : opt.complete
						});
			
		// 绑定点击事件
		[].slice.call(obj).forEach(function(button){
			button.addEventListener("click", function() {
				// 滚动大小
				var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft || 0,
					scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;

				opt.flyItem.style.left = event.clientX + scrollLeft + "px";
				opt.flyItem.style.top = event.clientY + scrollTop + "px";
				opt.flyItem.style.display = "inline-block";
				
				// 需要重定位
				parabolaFun.position().move();  
			});
		});
	};
	$.fn.myParabola = function(opt){
		return myParabola(this,opt);
	};
});