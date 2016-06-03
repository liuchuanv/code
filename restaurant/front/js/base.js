
var baseSite = "http://www.yanmanlou.com/";
var apiUrl =  baseSite + "restaurant/index.php/Api/",
	imgUrl = baseSite + "restaurant/";
	expire = 24 * 60 * 60 * 1000;	//过期时间 24小时
	
/**
 * 获取数据
 * 返回对象。如果localStorage中没有数据，则请求数据并设置添加时间，过期则重新请求
**/
function get(uri, param){
	var key = uri.substr(uri.lastIndexOf("/")+1);
	if(!empty(arguments[2])){
		key += "_" + arguments[2];
	}
	var val = getCache(key);
	if(!val){
		console.log("http请求__" + uri);
		$.ajax({
			url :	apiUrl + uri,
			async: false,	//同步
			type : "post",
			dataType : "json",
			data : param,
			success : function(data){
				setCache(key, data.data);
				val = getCache(key);
			}
		});
	}
	return val;
}
//重新从服务器获取该缓存
function resetCache(uri, param){
	var key = uri.substr(uri.lastIndexOf("/")+1);
	if(!empty(arguments[2])){
		key += "_" + arguments[2];
	}
	console.log("http请求__" + uri);
	$.ajax({
		url :	apiUrl + uri,
		async: false,	//同步
		type : "post",
		dataType : "json",
		data : param,
		success : function(data){
			setCache(key, data.data);
			val = getCache(key);
		}
	});
}
function setCache(key, data){
	var now = new Date().getTime();
	var obj = {"data" : data, "addtime" : now};
	localStorage.setItem(key, JSON.stringify(obj));
}
function getCache(key){
	var now = new Date().getTime();
	var val = localStorage.getItem(key);
	if(empty(val) || (now - parseInt(JSON.parse(val).addtime))>expire){
		removeCache(key)
		return false;
	}
	return JSON.parse(val).data;
}
function updateCache(key, data){
	var obj = JSON.parse(localStorage.getItem(key));
	if(obj){
		var tmpObj = {"data" : data, "addtime" : obj.addtime};
		localStorage.setItem(key, JSON.stringify(tmpObj));
		return true;
	}
	return false;
}
function removeCache(key){
	var new_key = key.substr(key.lastIndexOf("/")+1);
	if(!empty(arguments[1])){
		new_key += "_" + arguments[1];
	}
	localStorage.removeItem(new_key);
}
//判断字符串是否为空
function empty(strVal) {
	if (strVal == '' || strVal == null || strVal == undefined) {
		return true;
	} else {
		return false;
	}
}
//判断是否是空对象
function emptyObj(obj){
	for(var key in obj){
		return false;
	}
	return true;
}
//两位
function doublePlace(num){
	if(num<9){
		num = "0" + num;
	}
	return num;
}


var footerHtml = '<div class="container clearfix"> '+
				' <div class="footer-link">  '+
					' <h3 class="footer-link-title">用户帮助</h3> '+
					' <a class="footer-link-item" href="javascript:void(0)" target="_blank">服务中心</a> '+
					' <a class="footer-link-item" href="javascript:void(0)" target="_blank">常见问题</a> '+
					' <a class="footer-link-item" online-service="" href="javascript:void(0)" style="visibility: visible;">在线客服</a> '+
				' </div> '+
				' <div class="footer-link"> '+
					' <h3 class="footer-link-title">商务合作</h3> '+
					' <a class="footer-link-item" href="javascript:void(0)" target="_blank">我要开店</a> '+
					' <a class="footer-link-item" href="javascript:void(0)" target="_blank">加盟指南</a> '+
					' <a class="footer-link-item" href="javascript:void(0)" target="_blank">市场合作</a> '+
					' <a class="footer-link-item" href="javascript:void(0)" target="_blank">开放平台</a> '+
				' </div> '+
				' <div class="footer-link"> '+
					' <h3 class="footer-link-title">关于我们</h3> '+
					' <a class="footer-link-item" href="javascript:void(0)" target="_blank">介绍</a> '+
					' <a class="footer-link-item" href="javascript:void(0)" target="_blank">加入我们</a> '+
					' <a class="footer-link-item" href="javascript:void(0)" target="_blank">联系我们</a> '+
					' <a class="footer-link-item" href="javascript:void(0)" target="_blank">服务协议</a> '+
				' </div> '+
				' <div class="footer-contect"> '+
					' <div class="footer-contect-item">24小时客服热线 : '+
						' <a class="inherit" href="tel:123456">123456</a> '+
					' </div> '+
					' <div class="footer-contect-item">意见反馈 : '+
						' <a class="inherit" href="mailto:1254428526@qq.com">1254428526@qq.com</a> '+
					' </div> '+
					' <div class="footer-contect-item">关注我们 : '+
						' <span data-icon="&#xe604;" class="notice wechat"> '+
							' <img src="img/qrcode.png" width="150" height="150" /> '+
						' </span> '+
						' <a href="" data-icon="&#xe605;" class="notice webo"></a> '+
					' </div> '+
				' </div> '+
				' <div class="footer-copyright serif">增值电信业务许可证 : '+
					' <a href="javascript:void(0)" target="_blank">鲁xxxxxx</a> | '+
					' <a href="javascript:void(0)" target="_blank">鲁ICP备 123456</a> | '+
					' <a href="javascript:void(0)" target="_blank">xx工商行政管理</a> '+
					' Copyright ©2008-2015 xx, All Rights Reserved. '+
				' </div> '+
				' <div class="footer-police container"> '+
					' <a href="http://www.zx110.org/picp/?sn=123456" rel="nofollow" target="_blank"> '+
						' <img alt="已通过鲁公网备案，备案号 123456" src="" height="30"> '+
					' </a> '+
				' </div> '+
			' </div> ';
$(function(){
	$(".footer").html(footerHtml);
});