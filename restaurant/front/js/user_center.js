//
var data_0 = getCache("current_user");	//当前用户
var data_1 = get("Order/getOrderList", {"userId" : data_0.id});	//订单列表
var data_2 = get("AcceptAddress/get", {"userId" : data_0.id}, "addr");	//收货地址
$(function(){
	//用户
	if(data_0){
		$(".hd-top .info").html(_.template($("#userTpl").html(), data_0));
	}else{
		layer.alert("请先登录", {icon : 5}, function(){	
			window.location.href = "login.html";
		});
		setTimeout(function(){
			window.location.href = "login.html";
		}, 5000);
		return;
	}
	var PageView = function(){
		//初始化
		var hash = window.location.hash.replace("#", "");
		chanage(hash);
		
		$(".mn-left-menu li").click(function(){
			chanage($(this).index());
		});
		//右侧菜单
		function chanage(i){
			var ele = $(".mn-left-menu li").get(i);
			//样式变化
			$(ele).addClass("active").siblings().removeClass("active");
			//标题变化
			var strTitle = $(ele).find("a").text();
			$(".location").text(strTitle);
			//内容变化		
			var content = _.template($("#content_" + i).html(), eval("data_"+i));
			
			$(".mnr-main").html(content);
			//绑定事件（动态函数名）
			var strFun = "bindEvent_" + i + "()";
			eval(strFun);
		}
		/** 个人中心 **/
		function bindEvent_0(){
			//上传头像
			var params = {
				fileInput: $(".item-avatar input[type='file']").get(0),
				upButton: $(".confirmBtn").get(0),
				url: apiUrl+"Common/upload",
				filter: function(files) {
					var arrFiles = [];
					for (var i = 0, file; file = files[i]; i++) {	//关键是倒序	
						if (file.type.indexOf("image") == 0) {
							if (file.size >= 512000) {
								alert('您这张"'+ file.name +'"图片大小过大，应小于500k');	
							} else {
								arrFiles.push(file);	
							}			
						} else {
							alert('文件"' + file.name + '"不是图片。');	
						}
					}
					return arrFiles;
				},
				onSelect: function(files) {
					var funAppendImage = function() {
						file = files[0];
						if (file) {
							var reader = new FileReader()
							reader.onload = function(e) {
								$("#preview").attr("src", e.target.result);
							}
							reader.readAsDataURL(file);
						}
					};
					funAppendImage();	
					$(".btnWrap").show();
					$(".btnWrap .cancelBtn").click(function() {
						ZXXFILE.funDeleteFile(files[0]);
						return false;	
					});
				},
				onDelete: function(file) {
					$("#preview").attr("src", "img/default-avatar.png");
					$(".btnWrap").hide();
				},
				onSuccess: function(file, response) {
					this.head_img = response;
				},
				onComplete: function(file, response) {
					if(empty(this.head_img)){
						layer.msg("上传失败", {icon:5});
						return;
					}
					$("#preview").attr("src", imgUrl + this.head_img);
					$(".btnWrap").hide();
					//修改信息
					data_0.head_img = this.head_img;
					var param = {"userId":data_0.id, "head_img" : this.head_img};
					$.post(apiUrl+"User/update", param, function(data){
						if(data.status){
							layer.msg("更新成功", {icon:6});
							updateCache("current_user", data_0);
						}else{
							layer.msg("保存失败", {icon:5});
						}
					});
				}
			}
			ZXXFILE = $.extend(ZXXFILE, params);
			ZXXFILE.init();

			//点击编辑头像按钮
			$(".item-avatar a").click(function(){
				var uploadEle = $(".item-avatar input[type='file']");
				uploadEle.click();
			});
			
			//点击修改
			$(".changeNickName").click(function(){
				var $this = $(this);
				$this.hide();
				$this.next().show();
				//可写，获得焦点
				var ele = $this.prev();
				var strName = ele.text();
				ele.attr("contenteditable", 'true');
				ele.focus();
			});
			//保存昵称
			$(".saveNickName").click(function(){
				$(this).hide();
				$(this).prev().show();
				var txtEle = $(this).prev().prev();
				txtEle.attr("contenteditable", "false");
				//保存昵称
				data_0.uname = txtEle.text();
				var param = {"userId":data_0.id, "uname" : data_0.uname};
				$.post(apiUrl+"User/update", param, function(data){
					if(data.status){
						layer.msg("更新成功", {icon:6});
						updateCache("current_user", data_0);
					}else{
						layer.msg("保存失败", {icon:5});
					}
				});
			});
			
			$("#bindEmail").click(function(){
				layer.prompt({
						title: '输入邮箱，并确认',
						formType: 0 //prompt风格，支持0-2
					}, function(email){
						//发送验证码
						
						layer.prompt({title: '输入邮箱验证码', formType: 0}, function(verify){
							//绑定邮箱
					});
				}); 
			});
		}
		
		/** 最近订单 **/
		function bindEvent_1(){
			$(".order a").click(function(){
				//标题变化
				$(".location").text("订单详情");
				//内容变化		
				var index = $(this).parents(".order").index();
				var order = data_1[index];
				var content = _.template($("#content_4").html(), {"order" : order});
				$(".mnr-main").html(content);
				if(order.status == 0){
					$(".order-status2 li:first").addClass("active");
				}else if(order.status == 2){
					$(".order-status2 li:last").addClass("active");
				}else if(order.status > 0 && order.status < 2){
					$($(".order-status2 li").get(1)).addClass("active");
				}
				
			});
		}
		
		/** 收货地址 **/
		function bindEvent_2(){
			$(".updateAddr").click(function(){
				var id = $(this).parent().data("addrid");
				var i = $(this).parents(".accept-addr").index();
				var cont = _.template($("#content_3").html(),{"addr" : data_2[i]});
				var index = layer.open({
					type : 1,
					title : '<h3>编辑收货地址</h3>',
					area : ['700px', '480px'],
					content : cont,
				});
				$(".form-item input[type='submit']").click(function(){
					//保存收货地址
					var param = {
						"id"		: id,
						"user_id"	: data_0["id"],
						"phone"		: $(".addrForm input[name='phone']").val(),
						"location"	: $(".addrForm input[name='location']").val(),
						"address"	: $(".addrForm input[name='address']").val(),
						"contact"	: $(".addrForm input[name='contact']").val(),
						"sex"		: $(".addrForm input[name='sex']:checked").val(),
					};
					$.post(apiUrl + "AcceptAddress/update", param, function(data){
						if(data.status){
							resetCache("AcceptAddress/get", {"userId" : data_0.id}, "addr");
							window.location.reload();
						}else{
							layer.msg("保存失败", {icon:5});
						}
					});
					
				});
				$(".form-item input[name='cancel']").click(function(){
					layer.close(index);
				});
			});
			//添加新地址
			$("#addAddr").click(function(){
				var cont = _.template($("#content_3").html(),{"addr" : {}});
				var index = layer.open({
					type : 1,
					title : '<h3>编辑收货地址</h3>',
					area : ['700px', '480px'],
					content : cont
				});
				$(".form-item input[type='submit']").click(function(){
					//保存收货地址
					var param = {
						"user_id"	: data_0["id"],
						"phone"		: $(".addrForm input[name='phone']").val(),
						"location"	: $(".addrForm input[name='location']").val(),
						"address"	: $(".addrForm input[name='address']").val(),
						"contact"	: $(".addrForm input[name='contact']").val(),
						"sex"		: $(".addrForm input[name='sex']:checked").val(),
					};
					$.post(apiUrl + "AcceptAddress/add", param, function(data){
						if(data.status){
							resetCache("AcceptAddress/get", {"userId" : data_0.id}, "addr");
							window.location.reload();
						}else{
							layer.msg("保存失败", {icon:5});
						}
					});
					layer.close(index);
				});
				$(".form-item input[name='cancel']").click(function(){
					layer.close(index);
				});
			});
			//删除地址
			$(".delAddr").click(function(){
				var id = $(this).parent().data("addrid");
				$.post(apiUrl + "AcceptAddress/del", {"id" : id}, function(data){
					if(data.status){
						resetCache("AcceptAddress/get", {"userId" : data_0.id}, "addr");
						window.location.reload();
					}else{
						layer.msg("删除失败", {icon:5});
					}
				});
			});
		}
		
		
	};
	var page = new PageView();
	layer.config({
		extend: 'extend/layer.ext.js'
	});
});