//
$(function(){
	var loginView = function(){
		//初始化
		changeLoginWay(1);
		refreshVerify();
		//登录方式的变化
		$(".login-way").click(function(){
			if($(this).hasClass("is_default_way")){
				$(this).text("手机登录")
				$(this).removeClass("is_default_way")
				changeLoginWay(0);
			}else{
				$(this).text("普通方式登录")
				$(this).addClass("is_default_way")
				changeLoginWay(1);
				refreshVerify();
			}
		});
		function changeLoginWay(i){
			var content = $("#login_way_" + i).html();
			$(".login-form").html(content);
		}
		
		//刷新验证码
		$("#verify img, #verify a").click(function(){
			refreshVerify();
		});
		function refreshVerify(){
			$("#verify img").attr("src", apiUrl + "User/getPicCode?" + Math.random());
		}
		
		//
		$("input[type='submit']").click(function(){
			var checkCode = false;
			$.ajax({
				url :	apiUrl + "User/checkPicCode",
				async: false,	//同步
				type : "post",
				dataType : "json",
				data : {"picCode"	:	$.trim($("input[name='verify']").val())},
				success : function(data){
					checkCode = data.status;
				}
			});
			if(!checkCode){
				refreshVerify();
				layer.msg("验证码错误", {icon:5});
				return false;
			}
			
			var loginWay = $(this).data("loginway");
			var param = {
				"loginWay"	:	loginWay,
			};
			
			//用户名密码登录
			if(loginWay == 1){
				param.uname = $.trim($("input[name='username']").val()); 
				param.password = $.trim($("input[name='password']").val()); 
			}else if(loginWay == 2){
				param.phone = $.trim($("input[name='phone']").val()); 
				param.smsCode = $.trim($("input[name='verifycode']").val()); 
			}
			
			$.post(apiUrl+"User/login", param, function(data){
				if(data.status){
					setCache("current_user", data.data);
					window.location.href = "index.html";
				}else{
					layer.msg(data.info, {icon : 6});
				}
			});
		});
	};
	var loginPageView = new loginView();
});