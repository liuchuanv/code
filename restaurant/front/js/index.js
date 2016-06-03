
var data = get("Food/getFoodList", {});	//商品列表
var notice = get("Shop/syscfg", {"id" : "notice"}, "notice");	//商家公告
var deliverFee = get("Shop/syscfg", {"id" : "deliverFee"}, "deliverFee");	//配送费
var foodBoxFee = get("Shop/syscfg", {"id" : "foodBoxFee"}, "foodBoxFee");	//餐盒费
var user = getCache("current_user");

$(function(){
	console.log("index.js");
	/******* 数据*******/
	//导航
	$(".lf-nav ul").html(_.template($("#navTpl").html(), data));
	//楼层商品
	$(".lf-content").html(_.template($("#foodTpl").html(), data));
	//商家公告
	$(".main-notice").text(notice.content);
	//配送费
	$(".deliver-fee").text("配送费" + deliverFee.content);
	//用户
	if(user){
		$(".hd-top .info").html(_.template($("#userTpl").html(), user));
			//退出登录
		$("#quit").click(function(){
			//清除缓存
			removeCache("current_user");
			removeCache("AcceptAddress/get", "addr");		//清除我的收货地址缓存
			removeCache("Order/getOrderList");	//清除订单列表缓存
			window.location.href = "login.html";
		});
	}
	
	
	//导航定位
	$(".lf-nav").navposition({
		extraTop : 60,
		linkClass : "active",
		fixedClass : "lf-nav_fixed",
	});
	
	//商品数量加减按钮
	$(".item-quantity, .addsub").addClass("Spinner").Spinner();
	
	//商品对象，演示模型
	var Food = {
		id 		: '',
		name 	: '',
		amount	: '',
		price 	: '',
		target 	: '',
	};
	
	//购物车对象
	var BaseketView = {
		data : [],
		deliver_fee : deliverFee.content,
		addOne : function(obj, b){
			//第一次添加
			if(b){
				this.data.push(obj);
			}else{
				for(var i=0; i<this.data.length; i++){
					if(obj.id == this.data[i].id){
						this.data[i].amount += 1;
					}
				}
			}
			this.reader();
		},
		subOne : function(obj, callback){
			var index;
			for(var i=0; i<this.data.length; i++){
				if(obj.id == this.data[i].id){
					this.data[i].amount -= 1;
					if(this.data[i].amount <= 0){
						index = i;
						callback();
					}
					break;
				}
			}
			if(index != undefined){
				this.data.splice(index, 1);
			}
			this.reader();
		},
		clearView : function(){
			$("#basket .basket-item").remove();
			var numObj = $("#icon-cart").find(".cart-goods-quantity");
			var sumObj = $(".compute .total-money");
			numObj.text(0);
			sumObj.text(0);
			$("#basket").css("top", "-45px");
		},
		clearData : function(){
			for(var i=0; i<this.data.length; i++){
				var food = this.data[i];
				$(food.target).find(".Amount").val(0);
				$(food.target).find(".addsub").hide().prev().show();
			}
			this.data.length = 0;
			this.clearView();
			
		},
		//购物车中商品数量变化和页面中商品数量同步
		bindClickEvent : function(src, target){
			src.find(".Increase").click(function(){
				$(target).find(".Increase").click();
			});
			src.find(".Decrease").click(function(){
				$(target).find(".Decrease").click();
			});
			
		},
		
		//view重新渲染
		reader : function(){
			this.clearView();
			//数量变化，价格变化，总价变化
			for(var i=0; i<this.data.length; i++){
				var food = this.data[i];
				var obj = $("#goods_" + food.id);
				if(obj.length > 0){
					//数量变化
					var amountObj = obj.find(".Amount").val(food.amount);
					//价格变化
					var total = obj.find(".item-total");
					total.text(food.price * parseInt(amountObj.val()));
				}else{
					//
					var basket_item = '<div class="basket-item" id="goods_'+food.id+'"> '+
									' <div class="cell item-name">'+food.name+'</div> '+
									' <div class="cell item-quantity "></div> '+
									' <div class="cell item-total" data-icon="&#xe603;">'+(food.price * food.amount)+'</div> '+
								'</div>';
					$("#basket").append($(basket_item).find(".item-quantity").addClass("Spinner").Spinner({value:food.amount}).parent());
					//
					var top = parseInt($("#basket").css("top"))-45;
					$("#basket").css("top", top + "px");
					
					//绑定点击事件
					this.bindClickEvent($("#goods_" + food.id), food.target);
				}
				//总价变化
				var numObj = $("#icon-cart").find(".cart-goods-quantity");
				var sumObj = $(".compute .total-money");
				numObj.text($("#basket .basket-item").length);
				
				var sum = 0;
				var totalObjs = $("#basket .basket-item .item-total");
				for(var j=0; j<totalObjs.length; j++){
					sum += parseInt($(totalObjs[j]).text());
				}
				sumObj.text(sum);
				
				this.initGoods();
			}
		},
		
		initGoods : function(){
			for(var i=0; i<this.data.length; i++){
				var item = this.data[i];
				var carEle = $(".shopfood[data-foodid="+item.id+"] .addcart");
				carEle.hide().next().show().find(".Amount").val(item.amount);
			}
		}
	};
	
	//点击添加购物车
	$(".addcart").click(function(){
		//切换按钮
		$(this).hide().next().show();
		$(this).hide().next().find(".Amount").val(1);
		var foodEle = $(this).parents(".shopfood");
		//动画图片 
		var foodImg = foodEle.find(".col-1 img").attr("src");
		$("#flyItem").find("img").attr("src", foodImg);
		
		//添加
		var foodPriceStr = foodEle.find(".col-2 .foodprice").html();
		var food = {
			id 		: foodEle.data("foodid"),
			name 	: foodEle.find(".col-2 h3").text(),
			amount	: 1,
			price 	: $.trim(foodPriceStr.substring(foodPriceStr.lastIndexOf(">")+1, foodPriceStr.length)),
			target	: ".shopfood[data-foodid='"+foodEle.data("foodid")+"']"
		};
		BaseketView.addOne(food, true);
	});
	//+按钮
	$(" .Increase").click(function(){
		var foodEle = $(this).parents(".shopfood");
		//动画图片 
		var foodImg = foodEle.find(".col-1 img").attr("src");
		$("#flyItem").find("img").attr("src", foodImg);
		
		//添加
		var foodPriceStr = foodEle.find(".col-2 .foodprice").html();
		var food = {
			id 		: foodEle.data("foodid"),
			name 	: foodEle.find(".col-2 h3").text(),
			price 	: $.trim(foodPriceStr.substring(foodPriceStr.lastIndexOf(">")+1, foodPriceStr.length)),
			target	: foodEle
		};
		BaseketView.addOne(food, false);
	});
	//-按钮
	$(" .Decrease").click(function(){
		var obj = $(this);
		var foodEle = $(this).parents(".shopfood");
		//创建food对象
		var foodPriceStr = foodEle.find(".col-2 .foodprice").html();
		var food = {
			id 		: foodEle.data("foodid"),
			name 	: foodEle.find(".col-2 h3").text(),
			price 	: $.trim(foodPriceStr.substring(foodPriceStr.lastIndexOf(">")+1, foodPriceStr.length))
		};
		BaseketView.subOne(food, toggleBuyBtn);
		
		//回调函数，如果数量为0
		function toggleBuyBtn(){
			obj.parents(".addsub").hide().prev().show();
		}
	});
	
	//去结算
	$(".topay").click(function(){
		//数据存localStorage
		setCache("basket", BaseketView.data);
		window.location.href = "order.html";
	});
	//初始化购物车数据
	var basket = getCache("basket");
	if(!emptyObj(basket)){
		BaseketView.data = basket;
		BaseketView.reader();
	}
	
	//伸缩
	var top = 0 ;
	$(".compute").click(function(){
		var new_top = parseInt($("#basket").css("top"));
		$("#basket").animate({top : top},300);
		top = new_top;
	});
	
	//清空购物车
	$("#basket .basket-title a").click(function(){
		BaseketView.clearData();
	});
	
	
	// 抛物线动画
	var flyItem = document.querySelector("#flyItem"),
		target = document.querySelector("#icon-cart");
	$(".addcart, .shopfood .Increase").myParabola({
		flyItem : flyItem,
		target : target,
		speed : 100, //抛物线速度
		curvature : 0.0012, //控制抛物线弧度
		complete : function() {
			flyItem.style.display = "none";
			target.style.fontSize = "24px";
		}
	});

});