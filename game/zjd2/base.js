
/*** js本地缓存 ***/

//空值或空对象返回false
function setCache(name, value, expire){
	if(value && !isEmptyObj(value)){
		var obj = {'value':value, 'expire':expire, 'addtime': new Date().getTime()};
		var str = JSON.stringify(obj);
		localStorage.setItem(name, str);
		return ;
	}
	return false;
}
//过期则返回false并删除该缓存
function getCache(name){
	var str = localStorage.getItem(name);
	if(str){
		var obj = JSON.parse(str);
		if((obj['addtime']+obj['expire']) > new Date().getTime()){	//有效时间内
			return obj['value'];
		}else{
			removeCache(name);
		}
	}
	return false;
}
function removeCache(name){
	localStorage.removeItem(name);
}
/*** //js本地缓存 ***/

//判断对象是否为空,空true，非空或非对象false
function isEmptyObj(obj){
	if(typeof obj == 'object'){
		for(var i in obj){
			return false;
		}
		return true;
	}
	return false;
}