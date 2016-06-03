//
var food = getCache("basket");
var deliverFee = get("Shop/syscfg", {"id" : "deliverFee"}, "deliverFee");	//配送费
var foodBoxFee = get("Shop/syscfg", {"id" : "foodBoxFee"}, "foodBoxFee");	//餐盒费
var user = getCache("current_user");

var totalObj = {"total":0, "deliverFee" : deliverFee, "foodBoxFee" : foodBoxFee, "count" : food.length};

//收货地址
var accept_address = get("AcceptAddress/get", {"userId" : "1"}, "addr");

//监听函数
function watch(obj, attr, callback){
   if(typeof obj.defaultValues == 'undefined'){
	  obj.defaultValues = {};
	  for(var p in obj){
		if(typeof obj[p] !== 'object') 
			obj.defaultValues[p] = obj[p];
	  }
   }
   if(typeof obj.setAttr == 'undefined'){
		obj.setAttr = function(attr, value){  
			if(this[attr] != value){
				this.defaultValues[attr] = this[attr];
				this[attr] = value;
				return callback(this);
			}
			return this;             
	   };
   } 
   if(typeof obj.removeAttr == 'undefined'){
	  obj.removeAttr = function(attr){  
			this[attr] = undefined;
			return callback(this);           
	   };
   } 
}
$(function(){
	//用户
	if(!user){
		layer.alert("请先登录", {icon : 6}, function(){	
			window.location.href = "login.html";
		});
		setTimeout(function(){
			window.location.href = "login.html";
		}, 5000);
		return;
	}else{
		$(".hd-top .info").html(_.template($("#userTpl").html(), user));
	}
	
	var foodListView = function(data){
		this.data = data;
		this.reader();
	}
	foodListView.prototype = {
		el : ".food-list dl ",
		reader : function(){
			var that = this;
			$(".food-list dl").html("");	//清空
			var total = 0;
			for(var index in this.data){
				var item = this.data[index];
				total += item.total = item.amount * item.price;
				var html = ' <dd><div class="cell foodname">'+item.name+'</div> '+
							' <div class="cell foodamount"><div></div></div> '+
							' <div class="cell foodtotal" data-icon="&#xe603;">'+item.total+'</div></dd>';
				//商品数量加减按钮
				$(html).appendTo(that.el).find(".foodamount div").addClass("Spinner").Spinner({"min":1,"value":item.amount});
			};
			$(".Increase, .Decrease").click(function(){
				that.changeAmount();
			});
			//
			totalObj.setAttr("total", total);
		},
		changeAmount : function(){
			var that = this;
			$(this.el + " .foodamount input.Amount").each(function(index, ele){
				that.data[index].amount = $(this).val();
			});
			that.reader();
		},
	};

	var orderView = function(){
		var that = this;

		watch(totalObj, '', function(obj){
			that.changeFood();
		});
		that.foodListView = new foodListView(food);
		
		//收货地址
		that.accept_address = accept_address;
		
		that.reader();
	}
	orderView.prototype = {
		reader : function(){
			var that = this;
			that.changeFood();
			
			//收货地址
			for(var index in that.accept_address){
				var item = that.accept_address[index];
				if(index !=0 ){
					$(".mn-right .addr-body").append(getAcceptAddreeHtml(item, ""));
				}else{
					$(".mn-right .addr-body").html(getAcceptAddreeHtml(item, "active show"));
				}
			}
			function getAcceptAddreeHtml(obj, className){
				return '<div class="addr-item hide clearfix '+className+'" data-addrid="'+obj.id+'"> '+
							' <div class="fl iconfont">&#xe600;</div> '+
							' <div class="fl addr-info"> '+
								' <p>'+obj.contact+' '+(obj.sex?'先生':'女士')+' '+obj.phone+'</p> '+
								' <p>'+obj.address+'</p> '+
							' </div> '+
							' <a href="javascript:void(0)" class="addr-update">修改</a> '+
						' </div>';
			}
			$(".addr-item").click(function(){
				$(this).addClass("active").siblings().removeClass("active");
			});
			//更多地址
			$(".addr-foot").click(function(){
				var nextEle = $(".mn-right .addr-body .active").next(".show");
				if(nextEle.length > 0){
					$(".mn-right .addr-body .active").nextAll(".addr-item").removeClass("show");
				}else{
					$(".mn-right .addr-body .active").nextAll(".addr-item").addClass("show");
				}
			});
			
			//支付方式
			$(".pay-item").click(function(){
				$(this).addClass("active").siblings().removeClass("active");
			});
			
			//
			$(".addition .order_type input[type='radio']").click(function(){
				var val = $(this).val();
				switch(val){
					case "1" : {
						totalObj.setAttr("foodBoxFee", foodBoxFee);
						totalObj.setAttr("deliverFee", deliverFee);
					}break;
					case "2" : {
						totalObj.removeAttr("deliverFee");
						totalObj.setAttr("foodBoxFee", foodBoxFee);
					}break;
					case "3" : {
						totalObj.removeAttr("foodBoxFee");
						totalObj.removeAttr("deliverFee");
					}break;
				}
				that.changeFood();
			});
			//提交订单
			$("#submitOrder").click(function(){
				var data = {};
				var food = [];
				$.each(that.foodListView.data, function(i, val){
					food[i] = {};
					food[i]["food_id"] = val.id;
					food[i]["amount"] = val.amount;
				});
				data.foods = food;
				var today = new Date();
				data.book_time = today.getFullYear() + "-" + doublePlace(today.getMonth()) + "-" + doublePlace(today.getDate()) + " " + $("select[name='book_time']").val() + ":00";
				data.order_type = $("input[name='order_type']:checked").val();
				data.accept_address_id = $(".addr-body .active").data("addrid");
				data.user_id = 1;
				data.remark = $("input[name='remark']").val();
				
				$.post(apiUrl + "Order/submitOrder", data, function(data){
					if(data.status){
						removeCache("basket");	//清除购物车缓存
						removeCache("Order/getOrderList");	//清除订单列表缓存
						window.location.href="pay.html";	//支付页面
					}else{
						layer.msg(data.info, {icon:6});
					}
				});
			});
		},
		changeFood : function(){
			var that = this;
			$.ajax({
				url :	apiUrl + "Order/extraInfo",
				async: false,	//同步
				type : "post",
				dataType : "json",
				data :  {"total_money" : totalObj.total},
				success : function(data){
					var info = data.data;
					totalObj.favor = info.fillFavor;
				}
			});
			var total = parseFloat(totalObj.total) - parseFloat(totalObj.favor ? totalObj.favor.content : 0) + parseFloat(totalObj.foodBoxFee ? totalObj.foodBoxFee.content : 0) + parseFloat(totalObj.deliverFee ? totalObj.deliverFee.content:0);
			$(".mn-left .detail-total .big").text(total).next("p").text("共" + totalObj.count + "份商品");
			
			//订单详情
			$(".mn-left .detail-foods .foodBoxFee").remove();
			$(".mn-left .detail-foods .deliverFee").remove();
			$(".mn-left .detail-foods .fillFavor").remove();
			$(".mn-left .detail-foods").append(that.getFoodExtrHtml(totalObj.favor, "fillFavor", "cf33"));
			$(".mn-left .detail-foods").append(that.getFoodExtrHtml(totalObj.foodBoxFee, "foodBoxFee"));
			$(".mn-left .detail-foods").append(that.getFoodExtrHtml(totalObj.deliverFee, "deliverFee"));
		},
		getFoodExtrHtml : function(extra, className){
			if(extra){
				return  ' <div class="food-extra '+className+' clearfix"> '+
							' <div class="cell foodname">'+extra.title+'</div> '+
							' <div class="cell foodamount">&nbsp;</div> '+
							' <div class="cell foodtotal '+arguments[2]+'" data-icon="&#xe603;">'+extra.content+'</div> '+
						' </div>';
			}else{
				return "";
			}
		},
	};
	var orderPageView = new orderView();

});